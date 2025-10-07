<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'categoryId',
        'subcategoryid',
        'productname',
        'slugname',
        'rate',
        'cut_price',
        'AmountWithOutGST',
        'iGST',
        'iGSTAmount',
        'weight',
        'description',
        'isFeatures',
        'isTaxable',
        'isStock',
        'created_at',
        'updated_at',
        'strIP',
        'meta_title',
        'meta_keyword',
        'meta_description',
        'head',
        'body'
    ];
    protected $casts = [
        'rate' => 'decimal:2',
        'cut_price' => 'decimal:2',
        'usd_rate' => 'decimal:2',
        'usd_cut_price' => 'decimal:2',
        'AmountWithOutGST' => 'decimal:2',
        'iGST' => 'integer',
        'iGSTAmount' => 'decimal:2',
    ];

    // Returns INR or USD based on session
    public function getCurrencyAttribute(): string
    {
        return session('currency', 'USD');
    }

    public function getDisplayRateAttribute(): ?string
    {
        $val = $this->currency === 'INR' ? $this->rate : $this->usd_rate;
        return is_null($val) ? null : number_format((float)$val, 2, '.', '');
    }

    public function getDisplayCutPriceAttribute(): ?string
    {
        $val = $this->currency === 'INR' ? $this->cut_price : $this->usd_cut_price;
        return is_null($val) ? null : number_format((float)$val, 2, '.', '');
    }

    public function getDisplaySymbolAttribute(): string
    {
        return $this->currency === 'INR' ? '₹' : '$';
    }

    // Optional: price incl. GST for India only
    public function getDisplayRateInclTaxAttribute(): ?string
    {
        $raw = $this->currency === 'INR' ? $this->rate : $this->usd_rate;
        if (is_null($raw)) return null;

        $amount = (float)$raw;
        if ($this->currency === 'INR' && (int)$this->isTaxable === 1) {
            $amount = $amount + ($amount * ((int)$this->iGST) / 100);
        }
        return number_format($amount, 2, '.', '');
    }
}