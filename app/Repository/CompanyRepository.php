<?php

namespace App\Repository;

use App\Models\Company;
use Illuminate\Support\Facades\Storage;

class CompanyRepository {

    public function createOrUpdateCompany($params, $id = null) {
        try {
            $findCompany = Company::find($id);
            if(!$findCompany) {
                $company = new Company();
            } else {
                $company = $findCompany;
            }
            
            $company->name          = $params["name"];
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

            return responseCustom("Berhasil " . ($findCompany ? "Update" : "Simpan") . " Data Company!", true);
        } catch (\Exception $e) {
            return responseCustom($e->getMessage());
        }
    }
}
