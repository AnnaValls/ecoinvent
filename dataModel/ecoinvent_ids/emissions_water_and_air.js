/**
  * WATER EMISSIONS AND AIR EMISSIONS ECOINVENT IDS
  *
*/

//1. WATER EMISSIONS
var Water_emissions = {
  "COD":                     "fc0b5c85-3b49-42c2-a3fd-db7e57b696e3",
  "Nitrogen":                "ae70ca6c-807a-482b-9ddc-e449b4893fe3",
  "Nitrate":                 "7ce56135-2ca5-4fba-ad52-d62a34bfeb35",
  "Nitrite":                 "0017271e-7df5-40bc-833a-36110c1fe5d5",
  "Nitrogen_organic_bound":  "d43f7827-b47b-4652-8366-f370995fd206",
  "Phosphorus":              "b2631209-8374-431e-b7d5-56c96c6b6d79",

  "Chromium,_ion":           "e34d3da4-a3d5-41be-84b5-458afe32c990", //retained in sludge
  "Chromium_VI":             "8216fc31-15a1-4d33-858f-e09650b14c63", //emissions from WWTP and from CSO

  "Silver,_ion":             "af9793ba-25a1-4928-a14a-4bcf7d5bd3f7",
  "Aluminium":               "97e498ec-f323-4ec6-bcc0-d8a4c853bae3",
  "Arsenic,_ion":            "8c8ffaa5-84ed-4668-ba7d-80fd0f47013f",
  "Boron":                   "94e22edc-fe4b-4bab-9a09-a081595389cc",
  "Barium":                  "2c872773-0a29-4831-93b9-d49b116fa7d5",
  "Beryllium":               "276e755c-ed57-466a-b555-4658c791f385",
  "Bromine":                 "bac53020-1fed-4119-9242-33e4a2597560",
  "Calcium,_ion":            "ac066c02-b403-407b-a1f0-b29ad0f8188f",
  "Cadmium,_ion":            "af83b42f-a4e6-4457-be74-46a87798f82a",
  "Chlorine":                "ce312691-69ee-4cdb-9bd6-f717955b94b8",
  "Cobalt":                  "d4291dd5-dae8-47fa-bf06-466fcecbc210",
  "Copper,_ion":             "6d9550e2-e670-44c1-bad8-c0c4975ffca7",
  "Fluoride":                "00d2fef1-e4d4-4a16-8e81-b8cc514e4c25",
  "Iron,_ion":               "7c335b9c-a403-47a8-bb6d-2e7d3c3a230e",
  "Mercury":                 "66bfb434-78ab-4183-b1a7-7f87d08974fa",
  "Iodide":                  "e6360e00-79a2-455e-ac9d-2e3159736771",
  "Potassium,_ion":          "1653bf60-f682-4088-b02d-6dc44eae2786",
  "Magnesium":               "7bdab722-11d0-4c42-a099-6f9ed510a44a",
  "Manganese":               "f532985c-90b7-46fc-aac9-b039b40e22f1",
  "Molybdenum":              "442511cc-a98b-4242-9229-5736cb9a9399",
  "Sodium,_ion":             "1fc409bc-b8e7-48b2-92d5-2ced4aa7bae2",
  "Nickel,_ion":             "9798359e-a3ee-4362-a038-23a188582c6e",
  "Lead":                    "b3ebdcc3-c588-4997-95d2-9785b26b34e1",
  "Antimony":                "34b96163-a3df-4bc1-8224-e2a9fe01b23f",
  "Scandium":                "2f6bb945-2e93-4ea8-b3b6-7930c3680486",
  "Selenium":                "544dbea9-1d18-44ff-b92b-7866e3baa6dd",
  "Silicon":                 "fc2371dc-5bff-41f6-a155-697fbf727b56",
  "Tin,_ion":                "3ddb2e36-bc1b-43a5-8ef4-cbcdbeeeea70",
  "Strontium":               "4295ed5b-9824-4bbf-97a4-fc4cabd87f0d",
  "Titanium,_ion":           "ff36578b-f403-4656-b934-81d8d4e02dc8",
  "Thallium":                "d9008a06-991c-4acc-a33e-5483ffd2491e",
  "Vanadium,_ion":           "a46a250e-297d-43e9-b1c4-052cdcfb79c5",
  "Tungsten":                "7673fea9-b4ab-403e-b011-f1fb5a74ea2a",
  "Zinc,_ion":               "541b633c-17a3-4047-bce6-0c0e4fdb7c10",
}

//2. AIR EMISSIONS
var Air_emissions = {
  "CO2,_fossil":                     {"id":"f9749677-9c9f-4678-ab55-c607dfdc2cb9", "unitName":"kg"},
  "CO2,_from_soil_or_biomass_stock": {"id":"e8787b5e-d927-446d-81a9-f56977bbfeb4", "unitName":"kg"},
  "CO2,_non-fossil":                 {"id":"73ed05cc-9727-4abf-9516-4b5c0fe54a16", "unitName":"kg"},

  "CH4,_fossil":                     {"id":"5f7aad3d-566c-4d0d-ad59-e765f971aa0f", "unitName":"kg"},
  "CH4,_from_soil_or_biomass_stock": {"id":"299c6564-426e-48c3-b516-fdf301d12127", "unitName":"kg"},
  "CH4":                             {"id":"b53d3744-3629-4219-be20-980865e54031", "unitName":"kg"},
  "CH4,_non-fossil":                 {"id":"baf58fc9-573c-419c-8c16-831ac03203b9", "unitName":"kg"},

  "NOx":                             {"id":"d068f3e2-b033-417b-a359-ca4f25da9731", "unitName":"kg"},
  "N2O":                             {"id":"6dc1b46f-ee89-4495-95c4-b8a637bcd6cb", "unitName":"kg"},
  "Phosphorus":                      {"id":"198ce8e3-f05a-4bec-9f7f-325347453326", "unitName":"kg"},
}
