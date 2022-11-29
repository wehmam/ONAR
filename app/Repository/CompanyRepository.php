<?php

namespace App\Repository;

use App\Models\Company;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CompanyRepository {

    public function createOrUpdateCompany($params, $id = null) {
        try {

            DB::beginTransaction();

            $findCompany = Company::find($id);
            if(!$findCompany) {
                $company = new Company();
                $company->name          = $params["name"];
            } else {
                $company = $findCompany;
            }

            $company->description   = $params["description"];
            $company->address       = $params["address"];
            $company->phone_number  = $params["phone_number"];


            if(isset($params["upload_image"])) {
                if($findCompany) {
                    if(Storage::exists($findCompany->image)) {
                        Storage::delete($findCompany->image);
                    }
                }
                $company->image = Storage::putFile("public/images/company/" . $company->id, $params["upload_image"]);
            }

            $company->save();

            // ACTIVATED
            $activation = Activation::where("user_id", \Sentinel::check()->id)->first();
            if($activation) {
                $activation->completed_at = now();
                $activation->save();
            }

            DB::commit();

            return responseCustom("Berhasil " . ($findCompany ? "Update" : "Simpan") . " Data Company!", true);
        } catch (\Exception $e) {
            return responseCustom($e->getMessage());
        }
    }
}
