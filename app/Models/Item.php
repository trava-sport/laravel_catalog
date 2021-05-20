<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $guarded = false;

    protected $fillable = [
        'name', 'fabric_id', 'size_id', 'image', 'price'
    ];

    static public function get_items($request) {

        $sizes = [];
        $fabrics = [];
        //dd($request->priceFrom);
        $razmer = $request->razmer ? explode(',', $request->razmer) : '';
        $tkan = $request->tkan ? explode(',', $request->tkan) : '';
        $priceFrom = $request->priceFrom ? $request->priceFrom : '0';
        $priceTo = $request->priceTo ? $request->priceTo : '2000';
        //dd($razmer);
        //$price = explode(',', $request->price);
        $size_id =  !empty($razmer) ? Size::whereIn('code', $razmer)->get() : '';
        $fabric_id = !empty($tkan) ? Fabric::whereIn('code', $tkan)->get() : '';
        
        if ($size_id) {
            foreach ($size_id as $size) {
                $sizes[] = $size->id;
            }
        }

        if ($fabric_id) {
            foreach ($fabric_id as $fabric) {
                $fabrics[] = $fabric->id;
            }
        }
        //dd($priceFrom);

        if (empty($sizes) && !empty($fabrics)) {
            //dd($size_id);
            return  Item::whereIn('fabric_id', $fabrics)
                ->where([['price', '>=', $priceFrom], ['price', '<=', $priceTo]])->get();
        }
        if (empty($fabrics) && !empty($sizes)) {
            //dd($size_id);
            return  Item::whereIn('size_id', $sizes)
                ->where([['price', '>=', $priceFrom], ['price', '<=', $priceTo]])->get();
        }
        if (!empty( $fabrics) && !empty($sizes)) {
            return  Item::whereIn('size_id', $sizes)->whereIn('fabric_id',  $fabrics)
                ->where([['price', '>=', $priceFrom], ['price', '<=', $priceTo]])->get();
        }
        if (empty($fabrics) && empty($sizes) && $priceTo) {
            return  Item::where([['price', '>=', $priceFrom], ['price', '<=', $priceTo]])->get();
        }
    }
}
