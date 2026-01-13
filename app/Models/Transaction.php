<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
	protected $fillable = [
		'invoice_number',
		'total_amount',
		'payment_method',
		'payment_provider',
		'status',
		'notes',
		'product_id',
		'payment_proof'
	];
	protected $casts = [
		'notes' => 'array',
	];
}