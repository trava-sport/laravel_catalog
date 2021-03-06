<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Models\Size;
use App\Models\Fabric;

class MainController extends Controller
{
    public function index(Request $request) {
        $items = Item::get();

        if ($request->razmer || $request->tkan || $request->priceFrom || $request->priceTo) {
            $items = Item::get_items($request);
        }

        if($request->ajax()) {
            return view('ajax_item', ['items' => $items])->render();
        }

        $items_filter = Item::get();
        $list_id = $this->get_group_size($items_filter);

        $filter_size = Size::whereIn('id', $list_id[0])->get();
        $filter_fabric = Fabric::whereIn('id', $list_id[1])->get();
        
        return view('index', [
            'items' => $items,
            'filter_size' => $filter_size,
            'filter_fabric' => $filter_fabric
            ]);
    }

    private function get_group_size($items) {
        $sizes = [];
        $fabrics = [];
        foreach ($items as $item) {
            $sizes[] = $item->size_id;
            $fabrics[] = $item->fabric_id;
        }

        return [$sizes, $fabrics];
    }
}
