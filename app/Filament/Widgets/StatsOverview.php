<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Product;
use App\Models\Transaction;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $paidTransactions = Transaction::where('status', 'paid');
        $totalRevenue = $paidTransactions->sum('total_amount');
        $totalSold = $paidTransactions->count();
        $incomingOrders = Transaction::where('status', 'pending')->count();
        $completedOrders = $totalSold; // Assuming paid = completed for now as per discussion

        return [
            Stat::make('Pendapatan Total', 'Rp ' . number_format($totalRevenue, 0, ',', '.'))
                ->description('Dari ' . $completedOrders . ' order selesai')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            Stat::make('Total Produk Terjual', $totalSold)
                ->description('Akumulasi seluruh produk terjual')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('info'),

            Stat::make('Order Masuk', $incomingOrders)
                ->description('Menunggu konfirmasi')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Order Selesai', $completedOrders)
                ->description('Order yang sudah selesai')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
        ];
    }
}
