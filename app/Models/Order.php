<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['`order_id`', '`total_amount`', 'user_id'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['created_at','updated_at'];
    
    /**
     * Sub category to Parent category relationship with hasOne
     */
    public function getParentCatHasOne()
    {
        return $this->hasOne(Category::class, 'id', 'parent_category_id');
    }

    /**
     * Sub category to User relationship with hasOne
     */
    public function getCatUserHasOne()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function getParentCategoryHasOne()
    {
    return $this->hasOne(Category::class, 'id', 'parent_category_id');
    }

    
}