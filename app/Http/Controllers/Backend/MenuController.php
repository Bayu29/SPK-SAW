<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Menus\StoreMenuRequest;
use App\Http\Requests\Menus\UpdateMenuRequest;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class MenuController extends Controller
{
    public function index()
    {
        Gate::authorize('app.menus.index');

        $menus = Menu::latest('id')->get();

        return  view('backend.menus.index',compact('menus'));
    }

    public function create()
    {
        Gate::authorize('app.menus.create');

        return view('backend.menus.form');
    }

    public function store(StoreMenuRequest $request)
    {
        Menu::create([
            'name' => Str::slug($request->name),
            'description' => $request->description,
            'deletable' => true
        ]);

        notify()->success('Menu Successfully Added.', 'Added');

        return redirect()->route('app.menus.index');
    }

    public function edit(Menu $menu)
    {
        Gate::authorize('app.menus.edit');

        return view('backend.menus.form', compact('menu'));
    }

    public function update(UpdateMenuRequest $request, Menu $menu)
    {
        $menu->update([
            'name' => Str::slug($request->name),
            'description' => $request->description,
        ]);

        notify()->success('Menu Successfully Updated.', 'Updated');

        return redirect()->route('app.menus.index');
    }

    public function destroy(Menu $menu)
    {
        Gate::authorize('app.menus.destroy');

        if ($menu->deletable) {
            $menu->delete();
            notify()->success('Menu Successfully Deleted.', 'Deleted');
        } else {
            notify()->error('Sorry you can\'t delete system menu.', 'Error');
        }

        return back();
    }

    public function orderItem(Request $request)
    {
        Gate::authorize('app.menus.index');

        $menuItemOrder = json_decode($request->input('order'));
        $this->orderMenu($menuItemOrder, null);
    }

    private function orderMenu(array $menuItems, $parentId)
    {
        Gate::authorize('app.menus.index');

        foreach ($menuItems as $index => $menuItem) {
            $item = MenuItem::findOrFail($menuItem->id);
            $item->order = $index + 1;
            $item->parent_id = $parentId;

            $item->save();

            if (isset($menuItem->children)) {
                $this->orderMenu($menuItem->children, $item->id);
            }
        }
    }
}
