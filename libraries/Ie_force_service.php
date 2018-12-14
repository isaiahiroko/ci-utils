<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ie_force_service{
    
    protected $CI;
    protected $map;
    protected $http;

    protected $data;

    public function __construct($params = [])
    {
        $this->CI =& get_instance();
        $this->map = $params['map'];
        
        $this->CI->load->library('http_service', NULL, 'http');
        
        $this->http = $this->CI->http->client($params['base_uri']);
    }

    public function pull()
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        // $this->data = $this->http->request(
        //     'GET', 
        //     '',
        //     array(
        //         'query' => array(
        //             'integrationKey' => '3c7fc0243b4344709cd7b953bdce24ab',
        //             'providerId' => '47407',
        //             'fromDate' => '2018-01-01',
        //             'toDate' => '2018-08-23',
        //             'pageNo' => '1',
        //         ),
        //     )
        // );

        // $this->data = (array) json_decode(json_decode($this->data));
        $this->data = (array) json_decode('{
            "data": [
                {
                    "id": "12a6fd0c-a454-4c39-95dd-a945006b2ec6",
                    "parent": {
                        "id": "12a6fd0c-a454-4c39-95dd-a945006b2ec6",
                        "Row ID": "IKE103454",
                        "External ID": "BPS-5652",
                        "Status": "Submitted",
                        "Date": "23/08/2018",
                        "User Name": "Olatunji Arisekola S",
                        "Vendor": "BPS",
                        "Account Type": "Postpaid",
                        "Customer Type": "Existing",
                        "Business Unit": "IKEJA",
                        "Undertaking": "OGBA",
                        "DT Name": "11-Oke IraINJ-T2-Kayode-ADARANIJO",
                        "Account Number": "0101258649",
                        "Old Account Number": "0101258649",
                        "Old Meter Number": null,
                        "Split Account No": null,
                        "Feeder": "",
                        "DT Number": "",
                        "Customer Name": "DARANIJO/OLOKO ESTATE SECURTIY GATE",
                        "Meter Number": null,
                        "Customer Phone Number": "+2348094223110",
                        "Customer Address": "1,DARANIJO STREET, DARANIJO ESTATE, OGBA",
                        "Building Owners Name": "DARANIJO /OLOKO ESTATE SECURITY GATE",
                        "Current Meter Status": "No Meter",
                        "Meter Recommendation": "New Setup",
                        "No. of Meter Requires in Location": "1",
                        "Location": "http://maps.google.com/maps?q=6.6324842,3.3460217",
                        "Meter Type (Make)": "Conlog",
                        "Customer Status": "Residential",
                        "DT Capacity": "500",
                        "Current Tarrif": "S1",
                        "Recommanded Tariff": "S1",
                        "Meter Type Required": "1ph",
                        "Installation Type": "Pole",
                        "Type of Existing Meter": "N/A",
                        "Number of Service Wires": "2",
                        "Condition of Service Wire": "Good",
                        "Output Cable Distance (M)": "10",
                        "Input Cable Distance (M)": "8",
                        "Cable Size (mm)": "16mm",
                        "Service Wire Traceable to Meter Point": "Yes",
                        "Recommendations": null,
                        "Meter Point Wire Distribution": "Tidy",
                        "Correction Required by Customer": "The meter should be installed on the next Pole ,which is concrete,cos the existing one is woodensecu",
                        "Conclusion": "",
                        "Total Load": "1685",
                        "Type of Residence": "Security Post",
                        "Picture of survey location front view": "https://www.ie-force.com/Getimage.ashx?id=180823073702794000.jpg&FormId=SMAT-IKJA-PMIS&FormOrderId=12A6FD0C-A454-4C39-95DD-A945006B2EC6",
                        "Picture of customer bill": "https://www.ie-force.com/Getimage.ashx?id=180823073723197000.jpg&FormId=SMAT-IKJA-PMIS&FormOrderId=12A6FD0C-A454-4C39-95DD-A945006B2EC6",
                        "Picture of existing meter point": "https://www.ie-force.com/Getimage.ashx?id=180823073744762000.jpg&FormId=SMAT-IKJA-PMIS&FormOrderId=12A6FD0C-A454-4C39-95DD-A945006B2EC6",
                        "Picture of proposed meter point": "https://www.ie-force.com/Getimage.ashx?id=180823073813980000.jpg&FormId=SMAT-IKJA-PMIS&FormOrderId=12A6FD0C-A454-4C39-95DD-A945006B2EC6",
                        "Picture of service wire from the pole": "https://www.ie-force.com/Getimage.ashx?id=180823073839578000.jpg&FormId=SMAT-IKJA-PMIS&FormOrderId=12A6FD0C-A454-4C39-95DD-A945006B2EC6",
                        "SBC REP\'S  NAME": "AKIN(BPS)",
                        "Appliance": "Fan",
                        "ApplianceType": "Ceiling",
                        "Number": "1",
                        "TotalWattage": "85"
                    },
                    "childlist": [
                        {
                            "appliance": "Fan",
                            "applianceType": "Ceiling",
                            "number": "1",
                            "totalWattage": "85"
                        },
                        {
                            "appliance": "Lighting Bulb-Tungsten",
                            "applianceType": "Lighting Bulb-Tungsten",
                            "number": "25",
                            "totalWattage": "1500"
                        },
                        {
                            "appliance": "Television-1",
                            "applianceType": "Television-1",
                            "number": "1",
                            "totalWattage": "100"
                        }
                    ]
                },
                {
                    "id": "d46e4087-3ddf-476e-9b96-a94401293e5a",
                    "parent": {
                        "id": "d46e4087-3ddf-476e-9b96-a94401293e5a",
                        "Row ID": "IKE103315",
                        "External ID": "KLT2217",
                        "Status": "Submitted",
                        "Date": "22/08/2018",
                        "User Name": "Oyelaja Abiodun Odunayo",
                        "Vendor": "Klartek",
                        "Account Type": "Prepaid",
                        "Customer Type": "New",
                        "Business Unit": "IKEJA",
                        "Undertaking": "OKE IRA",
                        "DT Name": "11-Oke IraINJ-T1-Oke Ira-12 HVDS SHOMEFUN",
                        "Account Number": "",
                        "Old Account Number": null,
                        "Old Meter Number": null,
                        "Split Account No": null,
                        "Feeder": "11-Oke IraINJ-T1-Oke Ira",
                        "DT Number": "",
                        "Customer Name": "SHOLANKAN OLAMITOMI",
                        "Meter Number": "0100352535",
                        "Customer Phone Number": "07056666602",
                        "Customer Address": "14 SHOMEFUN STREET OKE IRA LAGOS",
                        "Building Owners Name": "SHOLANKAN OLAMITOMI",
                        "Current Meter Status": "No Meter",
                        "Meter Recommendation": "New Setup",
                        "No. of Meter Requires in Location": "1",
                        "Location": "http://maps.google.com/maps?q=6.6380583,3.3419983",
                        "Meter Type (Make)": "Momas",
                        "Customer Status": "Residential",
                        "DT Capacity": "555",
                        "Current Tarrif": "",
                        "Recommanded Tariff": "R2TP",
                        "Meter Type Required": "1ph",
                        "Installation Type": "Wall",
                        "Type of Existing Meter": "N/A",
                        "Number of Service Wires": "2",
                        "Condition of Service Wire": "Good",
                        "Output Cable Distance (M)": "12",
                        "Input Cable Distance (M)": "6",
                        "Cable Size (mm)": "16mm",
                        "Service Wire Traceable to Meter Point": "Yes",
                        "Recommendations": null,
                        "Meter Point Wire Distribution": "Tidy",
                        "Correction Required by Customer": "None",
                        "Conclusion": "Nonr",
                        "Total Load": "0",
                        "Type of Residence": "2-Bedroom Flat",
                        "Picture of survey location front view": "https://www.ie-force.com/Getimage.ashx?id=180822190737279000.jpg&FormId=SMAT-IKJA-PMIS&FormOrderId=D46E4087-3DDF-476E-9B96-A94401293E5A",
                        "Picture of customer bill": "https://www.ie-force.com/Getimage.ashx?id=180822190751159000.jpg&FormId=SMAT-IKJA-PMIS&FormOrderId=D46E4087-3DDF-476E-9B96-A94401293E5A",
                        "Picture of existing meter point": "https://www.ie-force.com/Getimage.ashx?id=180822190827283000.jpg&FormId=SMAT-IKJA-PMIS&FormOrderId=D46E4087-3DDF-476E-9B96-A94401293E5A",
                        "Picture of proposed meter point": "https://www.ie-force.com/Getimage.ashx?id=180822190856520000.jpg&FormId=SMAT-IKJA-PMIS&FormOrderId=D46E4087-3DDF-476E-9B96-A94401293E5A",
                        "Picture of service wire from the pole": "https://www.ie-force.com/Getimage.ashx?id=180822190907065000.jpg&FormId=SMAT-IKJA-PMIS&FormOrderId=D46E4087-3DDF-476E-9B96-A94401293E5A",
                        "SBC REP\'S  NAME": "Abiodun (klarket)",
                        "Appliance": null,
                        "ApplianceType": null,
                        "Number": null,
                        "TotalWattage": null
                    },
                    "childlist": [
                        {
                            "appliance": null,
                            "applianceType": null,
                            "number": null,
                            "totalWattage": null
                        }
                    ]
                }
            ]
        }');
        $this->data = $this->data['data'];
        return $this;
    }

    public function push()
    {
        return $this->to_db('surveys');
            // && $this->to_db('customers')
            // && $this->to_db('meters')
            // && $this->to_db('orders');
    }

    public function to_db($type, $id = NULL)
    {
        $types = $this->filter($type);

        $this->CI->load->model($type.'_model', $type);

        $singuar_type = $this->CI->inflector->singularize($type);
        foreach ($types as $type_data) {
            $this->CI->{$type}->upsert(array(
                $singuar_type.'_id' => $type_data[$singuar_type.'_id']
            ), $this->fillable($type_data, $this->CI->{$type}->fillable()));
        }

        return $types;
    }

    protected function filter($type)
    {
        return array_map(function ($item) use ($type) {
            $filtered_and_mapped = array();
            $item = (array) $item;
            $parent = (array) $item['parent'];
            $child = $item['childlist'];

            if($type == 'surveys'){
                $filtered_and_mapped['load_assessment'] = json_encode($child);
            }
            foreach ($parent as $key => $value) {
                $key = strtolower($key);
                if(array_key_exists($key, $this->map[$type])){
                    $filtered_and_mapped[$this->map[$type][$key]] = $value;
                }
            }

            return $filtered_and_mapped;

        }, $this->data);
    }

    
    protected function fillable($data, $fillable, $not_fillable = array())
    {
        return array_filter($data, function ($v, $k) use ($fillable, $not_fillable) {
            return in_array($k, $fillable)
                && !in_array($k, $not_fillable);
        }, ARRAY_FILTER_USE_BOTH);
    }
    
}