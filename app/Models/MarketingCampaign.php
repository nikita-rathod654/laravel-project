<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketingCampaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'channel',
        'target_audience',
        'budget',
        'spent',
        'impressions',
        'clicks',
        'conversions',
        'status',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'budget' => 'decimal:2',
        'spent' => 'decimal:2',
        'impressions' => 'integer',
        'clicks' => 'integer',
        'conversions' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date',
    ];
}
