<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    //protected $fillable = ['title', 'company', 'location', 'website', 'email', 'tags', 'description'];

    //used to filter the data that gets displayed on th ewebpage based on the tag
    public function ScopeFilter($query, array $filters)
    {
        if(isset($filters['tag'])){
            $query->where('tags', 'like', '%' . $filters['tag'] . '%');
            //tags is the name of the column in the databse that we are filtering based on so this line of code checks for rows in the tag column that macthes the tag and returns the row
        };

        if(isset($filters['search'])){
            $query->where('title', 'like', '%' . $filters['search'] . '%')
            ->orWhere('description', 'like', '%' . $filters['search'] . '%')
            ->orWhere('tags', 'like', '%' . $filters['search'] . '%')
            
            ;
            //tags is the name of the column in the databse that we are filtering based on so this line of code checks for rows in the tag column that macthes the tag and returns the row
        };
        
    }

     //relationship between the user and the listing
     public function user(){
        //this says whenever a listing is created it belongs to a user 
        //and the user_id is the foreign key in the listings table
        return $this->belongsTo(User::class, 'user_id');
    }
    
}

