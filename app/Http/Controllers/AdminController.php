<?php

namespace App\Http\Controllers;

use App\Constants\ItemsPerPage;
use App\Enums\UserRoleEnum;
use App\Events\CreateProviderProcessed;
use App\Events\DeletedProviderProcessed;
use App\Http\Requests\ProviderEditRequest;
use App\Http\Requests\ProviderRegisteringRequest;
use App\Http\Requests\StationRegisteringRequest;
use App\Models\Province;
use App\Models\ServiceProvider;
use App\Models\Station;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;

class AdminController extends Controller
{
    public function index()
    {
        View::share('title', 'Home');
        $providers = ServiceProvider::all()->toArray();
        return view('admin.index')->with([
            'providers' => $providers
        ]);
    }
    public function user_index(Request $request)
    {

        //preparation for sort and filter
        $itemsPerPage = ItemsPerPage::USER;
        $sortCol = $request->sortCol ?? 'id';
        $sortType = $request->sortType ?? 'asc';
        $searchCol = $request->searchCol ?? 'name';
        $searchVal = $request->searchVal ?? '';
        $address = $request->address ?? 'null';
        $address2 = $request->address2 ?? 'null';
        $role = $request->role ?? 'null';
        $includedTotalPage = !empty($request->isFilter) || empty($request->isAPI) ? 1 : 0;
        $offset = $request->pageNum ? ($request->pageNum - 1) * $itemsPerPage : 0;


        $data=User::get_user_with_filter_sort($searchCol,$searchVal,$sortCol,$sortType,$address,$address2,$role,$offset,$itemsPerPage,$includedTotalPage);

        if (!empty($request->isAPI)) return json_encode([
            'users' => $data['users'],
            'totalPage' => $data['totalPage']
        ]);

        View::share('title', 'UsersList');
        return view('admin.user.index', [
            'users' => $data['users'],
            'total_page' =>$data['totalPage'],
            'roles' => UserRoleEnum::asArray()
        ]);
    }



    //provider
    public function provider_create()
    {
        View::share('title', 'ProviderCreation');
        return view('admin.provider.create');
    }
    public function provider_store(ProviderRegisteringRequest $request)
    {
        $toInsert = $request->only('phone_number', 'name', 'address');
        $toInsert['employer_id'] = User::query()->where('email', $request->email)->first()->id;
        CreateProviderProcessed::dispatch($toInsert['employer_id']);
        return ServiceProvider::create($toInsert);
    }
    public function provider_index()
    {
        View::share('title', 'Home');
        $providers = ServiceProvider::with(['province','comments'])->get();
        $providers->append('address_name');
        $providers->append('rate_infor');

        return view('admin.provider.index')->with([
            'providers' => $providers->toArray()
        ]);
    }
    public function provider_edit(int $id)
    {
        View::share('title', 'ProviderEdition');
        $provider = ServiceProvider::find($id);
        $provider->append('email');
        return view('admin.provider.edit', ['provider' => $provider]);
    }
    public function provider_destroy(int $id)
    {
        try {
            DeletedProviderProcessed::dispatch($id);
            ServiceProvider::destroy($id);
        } catch (Exception $e) {
            return back()->withError('Phải xóa tất cả hoạt động và tài sản của nhà xe trước'); //$e->getMessage()
        }
        return redirect()->route('admin.provider.index');
    }
    public function provider_update(int $id, ProviderEditRequest $request)
    {
        $toUpdate = ServiceProvider::find($id);
        $newuser = User::query()->where('email', $request->email)->first();
        $olduser = User::find($toUpdate->employer_id);
        if ($newuser != $olduser) {
            $newuser->role = UserRoleEnum::EMPLOYER;
            $newuser->save();
            $olduser->role = UserRoleEnum::PASSENGER;
            $olduser->save();
        }
        $toUpdate->employer_id = $newuser->id;
        $toUpdate->phone_number = $request->phone_number;
        $toUpdate->name = $request->name;
        $toUpdate->address = $request->address;
        $toUpdate->save();
        return $toUpdate;
    }


    //station
    public function station_index()
    {
        View::share('title', 'Station');
        $stations = Station::with(['province', 'district'])->get();
        $stations->append('province_name');
        $stations->append('district_name');
        return view('admin.station.index')->with([
            'stations' => $stations->toArray()
        ]);
    }
    public function station_create()
    {
        View::share('title', 'StationCreation');
        return view('admin.station.create');
    }
    public function station_store(StationRegisteringRequest $request)
    {
        $toInsert = $request->only('address2', 'name', 'address');
        return Station::create($toInsert);
    }
    public function station_destroy(int $id)
    {
        try {
            Station::destroy($id);
        } catch (Exception $e) {
            return back()->withError('Không thể xóa bến này vì đã được chọn trong lịch trình'); //$e->getMessage()
        }
        return redirect()->route('admin.station.index');
    }
}
