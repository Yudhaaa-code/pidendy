<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('invoice_number')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->label('Nomor Invoice'),
                Forms\Components\TextInput::make('total_amount')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->label('Total Pembayaran'),
                Forms\Components\Select::make('payment_method')
                    ->label('Metode Pembayaran')
                    ->options([
                        'bank' => 'Transfer Bank',
                        'ewallet' => 'E-Wallet',
                    ])
                    ->live()
                    ->required(),
                Forms\Components\Select::make('payment_provider')
                    ->label('Provider')
                    ->options(function (Forms\Get $get) {
                        return $get('payment_method') === 'ewallet'
                            ? [
                                'dana' => 'DANA',
                                'ovo' => 'OVO',
                                'gopay' => 'GoPay',
                              ]
                            : [
                                'bca' => 'BCA',
                                'bni' => 'BNI',
                                'mandiri' => 'Mandiri',
                              ];
                    })
                    ->required(),
                Forms\Components\Select::make('status')
                    ->required()
                    ->options([
                        'pending' => 'Menunggu Pembayaran',
                        'paid' => 'Sudah Dibayar',
                        'cancelled' => 'Dibatalkan'
                    ])
                    ->label('Status'),
                Forms\Components\Textarea::make('notes')
                    ->label('Catatan')
                    ->rows(3),
                Forms\Components\FileUpload::make('payment_proof')
                    ->label('Bukti Pembayaran')
                    ->disk('public')
                    ->directory('payment_proofs')
                    ->acceptedFileTypes(['image/*'])
                    ->maxSize(2048)
                    ->downloadable()
                    ->openable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('invoice_number')
                    ->searchable()
                    ->sortable()
                    ->label('Nomor Invoice'),
                Tables\Columns\TextColumn::make('notes.recipient_name')
                    ->label('Nama Pembeli')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('notes.phone')
                    ->label('No. Telepon')
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_amount')
                    ->money('idr')
                    ->sortable()
                    ->label('Total Pembayaran'),
                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Metode')
                    ->formatStateUsing(fn ($state) => $state === 'ewallet' ? 'E-Wallet' : 'Transfer Bank')
                    ->badge()
                    ->colors([
                        'primary' => ['bank', 'ewallet'],
                    ]),
                Tables\Columns\TextColumn::make('payment_provider')
                    ->label('Provider')
                    ->formatStateUsing(function ($state) {
                        $map = [
                            'bca' => 'BCA', 'bni' => 'BNI', 'mandiri' => 'Mandiri',
                            'dana' => 'DANA', 'ovo' => 'OVO', 'gopay' => 'GoPay',
                        ];
                        return $map[$state] ?? '-';
                    })
                    ->badge(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'paid',
                        'danger' => 'cancelled',
                    ])
                    ->label('Status'),
                Tables\Columns\ImageColumn::make('payment_proof')
                    ->label('Bukti')
                    ->disk('public')
                    ->size(48)
                    ->toggleable(false)
                    ->url(fn (Transaction $record) => $record->payment_proof ? asset('storage/' . $record->payment_proof) : null, true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Tanggal Dibuat'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('verifyPayment')
                    ->label('Verifikasi')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (Transaction $record) => $record->status === 'pending')
                    ->action(function (Transaction $record): void {
                        $record->update([
                            'status' => 'paid',
                        ]);
                    }),
                Tables\Actions\Action::make('rejectPayment')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (Transaction $record) => $record->status === 'pending')
                    ->form([
                        Forms\Components\Textarea::make('reason')
                            ->label('Alasan Penolakan')
                            ->rows(3)
                            ->required(),
                    ])
                    ->action(function (Transaction $record, array $data): void {
                        $existingNotes = $record->notes;
                        $reason = $data['reason'] ?? '';
                        
                        // Handle notes as array (due to cast) or string (fallback)
                        if (is_array($existingNotes)) {
                            $existingNotes['reject_reason'] = $reason;
                            $newNotes = $existingNotes; // Eloquent will json_encode it automatically
                        } else {
                            // Fallback for old records or if cast fails
                            try {
                                $decoded = json_decode($existingNotes ?? '[]', true, 512, JSON_THROW_ON_ERROR);
                                $decoded['reject_reason'] = $reason;
                                $newNotes = $decoded;
                            } catch (\Throwable $e) {
                                // If it's a plain string, just append
                                $newNotes = ['original' => $existingNotes, 'reject_reason' => $reason];
                            }
                        }
                        
                        $record->update([
                            'status' => 'cancelled',
                            'notes' => $newNotes,
                        ]);
                    }),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
