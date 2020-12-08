<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AddressResource;
use App\Http\Resources\ClientResource;
use App\Http\Traits\GeneralTrait;
use App\Models\Client;
use App\Models\Address;
use App\Models\Point;
use App\Rules\CurrentPasswordCheckRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class ClientController extends Controller
{
    //

    use GeneralTrait;

    public function __construct()
    {


        $this->middleware("auth:client-api");

    }

    public function client_profile(Request $request)
    {


        $client = getUser();


        return $this->returnData(['client'], [new ClientResource($client)]);

    }

    public function updateprofile(Request $request)
    {


        $client = getUser();


        $rules = [
            'name' => 'nullable|string|min:5|max:30|not_regex:/([%\$#\*<>]+)/',
            'email' => ['nullable', 'email', Rule::unique((new Client)->getTable()),],
            'mobile_number' => ['nullable', 'digits:11', Rule::unique((new Client)->getTable())->ignore($client->id)],
        ];

        $validator = \Validator::make($request->all(), $rules);


        if ($validator->fails()) {


            return $this->returnError(422, $validator->errors()->first());

        }

        $client->update(
            request()->all()
        );


        return $this->returnSuccessMessage('your data has been updated successfully', 200);


    }

    public function clientpoints(Request $request)
    {
        $udid = $request->header('udid');


        $client = getUser();

        $points = Point::simplePaginate();
        return $this->returnData(['client points', "points", "more_points"], [$client->total_points ?? 0, $points->getCollection(), $points->hasMorePages()]);

    }
public function usePoints()
{
    Point::where();
}
    public function clientaddresses(Request $request)
    {
        $udid = $request->header('udid');


        $client = \auth("client-api")->check() ? \auth("client-api")->user() : Client::where("unique_id", $udid)->first();

        if ($client) {
            $addresses = $client->addresses()->get();

            foreach ($addresses as $address) {
                $address->name = $client->name;
                $address->name = $client->name;
                $address->mobile_number = $client->mobile_number;
                $address->default = $address->default;
                $address->address_lable = $address->address_lable;
                $address->lat = $address->lat;
                $address->lon = $address->lon;
                $address->govern = $address->govern;
                $address->additional = $address->additional;

            }

            return $this->returnData(['client addresses'], [AddressResource::collection($addresses)]);
        }
    }

    public function validateAddress()
    {
        $validation = \Validator::make(\request()->all(), [
            "address_id" => "required|exists:users,id",
            "code" => "required"
        ]);
        if ($validation->fails()) {
            return $this->returnValidationError(422, $validation);
        }
        $address = Address::find(\request("address_id"));
        if ($address->verify == request("code")) {
            $address->update(["verified" => 1]);
            $this->returnSuccessMessage("address verified");
        }
        return $this->returnError(422, "code is invalid");
    }

    public function resetpassword(Request $request)
    {


        $mobile = $request->mobile;

        $client = Client::where('mobile_number', $mobile)->first();


        $validator = Validator::make($request->all(), [
            'password' => ['required'],
        ]);

        if ($validator->fails()) {


            return $this->returnError(300, 'These data is not valid');

        }


        $client->update(['password' => Hash::make($request->password),]);

        return $this->returnData(['client'], [$client], 'password updated successfully');


    }

    public function changepassword(Request $request)
    {


        $udid = $request->header('udid');

        if (auth("client-api")->check()) {
            $client = \auth("client-api")->user();
        } else {
            $client = Client::where('unique_id', $udid)->first();

        }


        $validator = \Validator::make($request->all(), [
            'old_password' => ['required'],
            'new_password' => ['required', 'confirmed', 'different:old_password'],
        ]);


        if ($validator->fails()) {


            return $this->returnError(300, 'These data is not valid');
        }


        if (Hash::check($request->old_password, $client->password)) {
            $client->update(['password' => Hash::make($request->new_password),]);


            return $this->returnData(['client'], [$client], 'password updated successfully');

        } else {

            return $this->returnError(422, 'the old password is not in our records');
        }

    }


    public function add_address(Request $request)
    {


        $client = \auth("client-api")->user();


        $validator = \Validator::make($request->all(), [
            'address' => ['required', 'min:2', 'not_regex:/([%\$#\*<>]+)/'],
            'label' => ['required', 'string'],
            'default' => ["required", 'boolean'],
            'lat' => ['required', 'string'],
            'lon' => ['required', 'string'],
            'additional' => ['nullable'],
            'govern' => 'required|string',
            'name' => 'required|string',
            'phone' => 'required|string',
        ]);


        if ($validator->fails()) {


            return $this->returnError(300, $validator->errors()->first());

        }

        $name = $request->name;
        $phone = $request->phone;
        $address = $request->address;
        $label = $request->label;
        $client_id = $client->id;
        $default = $request->default;
        $lat = $request->lat;
        $lon = $request->lon;
        $additional = $request->additional;
        $govern = $request->govern;
        $rand = "12345";
        Address::create([
            'name' => $name,
            'phone' => $phone,
            'description' => $address,
            'address_lable' => $label,
            'client_id' => $client_id,
            'default' => $default,
            'lat' => $lat,
            'lon' => $lon,
            'additional' => $additional,
            'govern' => $govern,
            "verified" => 0,
            "verify" => $rand
        ]);


        return $this->returnSuccessMessage("address created successfully", 200);


    }

    public function get_address(Request $request)
    {


        $client = \auth("client-api")->user();


        if (count($client->addresses) < 1) {

            return $this->returnError('', 'there is no addresses for this client registered');
        }
        return $this->returnData(['client_addresses'], [AddressResource::collection($client->addresses)]);

    }

    public function delete_address(Request $request)
    {


        $client = \auth("client-api")->user();


        if ($client) {
            $address = Address::find($request->id);

            if ($address) {

                $address->delete();

                return $this->returnSuccessMessage('deleted successfully');
            } else {

                return $this->returnError(404, 'id not found');

            }

        } else {


            return $this->returnError(401, 'Unauthorized');

        }

    }

    public function update_address(Request $request)
    {


        $client = \auth()->user();


        $validator = \Validator::make($request->all(), [
            'address' => ['min:2', 'not_regex:/([%\$#\*<>]+)/'],
            'label' => ['string'],
            'default' => ['boolean'],
            'lat' => ['string'],
            'lon' => ['string'],
            'govern' => ['string'],
            'additional' => ['nullable'],
            'name' => ['string'],
            'phone' => ['string'],
        ]);


        if ($validator->fails()) {

            return $this->returnError(422, 'These data is not valid');

        }


        if (count($client->addresses) >= 1) {
            $address = $client->addresses()->where('id', $request->address_id)->first();
            if ($address) {

                $request_data = $request->except('address_id', "address", "label");
                $request_data["address_lable"] = $request->label;
                $request_data["name"] = $request->address;
                $address->update($request_data);

            } else {


                return $this->returnError(404, 'address not found');

            }


            return $this->returnSuccessMessage('updated successfully', 200);


        }
    }
}

