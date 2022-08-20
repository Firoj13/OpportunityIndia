<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use \Venturecraft\Revisionable\RevisionableTrait;

class LeadSupplier extends Model
{
    use HasFactory;
    use RevisionableTrait;

    protected $table = 'leads_supplier';
     
	protected $primaryKey = 'lead_id';

    protected $fillable = ['supplier_id',' mapping_timestamp' ];

    public function buyer()
    {
        return $this->belongsTo(Brand::class,'supplier_id', 'brand_id');
    }


}