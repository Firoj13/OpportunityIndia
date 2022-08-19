<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Venturecraft\Revisionable\RevisionableTrait;
use Illuminate\Support\Facades\DB;

class LeadDetail extends Model
{
    use HasFactory;
    
    use RevisionableTrait;
	
	protected $revisionCreationsEnabled = true;

    protected $table = 'leads_details';

	protected $fillable = ['lead_id','attribute_name','attribute_value','post_time'];

	
	public function lead() {

		return $this->hasOne(Lead::class,'lead_id', 'lead_id');
	
	}
    /**
     * Instance the revision model
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function newModel()
    {
        $model = app('config')->get('revisionable.model');

        if (! $model) {
            $model = 'Venturecraft\Revisionable\Revision';
        }

        return new $model;
    }

    /**
    * Called after record successfully created
    */
    public function postCreate()
    {

        // Check if we should store creations in our revision history
        // Set this value to true in your model if you want to
        if(empty($this->revisionCreationsEnabled))
        {
            // We should not store creations.
            return false;
        }

        if ((!isset($this->revisionEnabled) || $this->revisionEnabled))
        {
            $revisions[] = array(
                'revisionable_type' => $this->getMorphClass(),
                'revisionable_id' => $this->getKey(),
                'key' => self::CREATED_AT,
                'old_value' => "___",
                'new_value' => $this->updatedData['attribute_value'],
                'user_id' => $this->getSystemUserId(),
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),
            );

            $revision = static::newModel();
            DB::table($revision->getTable())->insert($revisions);
        }
    }
}
