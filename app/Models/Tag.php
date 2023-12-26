<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    
    public function posts(){
        return $this -> belongsToMany(Post::class);
    }
    
    public function tagCheck($selectedTags,$tag){
        
        foreach($selectedTags as $selectedTag){
            if($selectedTag->id === $tag->id){
                return true; 
            }    
        }    
        
    }
}
