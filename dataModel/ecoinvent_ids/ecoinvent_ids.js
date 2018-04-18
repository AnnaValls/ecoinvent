//map between ecoinvent ids and this tool variable names
//can be inputs and/or outputs
/* "resources" folder: ecoinvent ids
  - properties.json (ww activity + ww influent + sludge composition)
  - emissions_to_water.json
  - emissions_to_air.json
*/

var Ecoinvent_ids={
  inputs:{
    //compounds not in the tool TBD
    "DOC"  : "efe22a60-b1a3-4b33-a5ba-4bf575e0a889", // not used
    "TN"   : "f04a971d-f503-4ca0-b2b1-0ecd2e53ea61", // total nitrogen, we use TKN instead
    "SO4"  : "1e4ef691-c7d3-49fc-9aee-6d77575a7b8a", // dissolved sulfate SO4 as S (we don't have TS in the model)
    "pOS"  : "8175120e-a5b7-4f19-afca-5620e9e4dd8b", // particulate sulfur (we don't have TS in the model)
    "TS"   : "7f3410da-b91e-40d8-9545-ab269ff66900", // total sulfur (we don't have TS in the model)

    //key components (inputs)
    "TKN" : "98549452-463c-463d-abee-a95c2e01ade3",
    "BOD" : "dd13a45c-ddd8-414d-821f-dfe31c7d2868",
    "COD" : "3f469e9e-267a-4100-9f43-4297441dc726",
    "NH4" : "f7fa53fa-ee5f-4a97-bcd8-1b0851afe9a6",
    "TP"  : "8e73d3fb-bb81-4c42-bfa6-8be4ff13125d",
    "PO4" : "7fe01cf6-6e7b-487f-b37e-32388640a8a4",
    "TSS" : "fc26822f-6400-41a5-aac6-94b7088bdabe",

    //key components (calculated)
    "TOC"  : "a547f885-601d-4d52-9bf9-60f0cef06269", //
    "NO3"  : "4f461b9d-5a7b-4a46-8803-23f6df0dc522", // NOx is NO3
    "NO2"  : "c8ebc911-268a-4dfe-a426-73e1e35b587a", // NO2 is zero
    "sTKN" : "4d60d7ca-8f4b-4d14-b137-3670858e48ca",
    "pON"  : "88c9f622-8451-41aa-98b0-c56b191a7e0a",
    "sON"  : "cbc4a2c2-1710-4e6c-9b90-e1e72819d7b9",
    "pOP"  : "0f205308-d33a-430b-b3ec-b62bef311f2f",

    //metals and other elements
    "Ag" : "dcdc6c7b-0b72-4174-bc90-f51ed66426d5",
    "Al" : "77154d2e-4b05-48f2-a89a-789acd170497",
    "As" : "b321f120-4db7-4e7c-a196-82a231023052",
    "B"  : "c0447419-7139-44fe-a855-ea71e2b78585",
    "Ba" : "33976f6b-2575-4410-8f60-d421bdf3e554",
    "Be" : "d21c7c5c-b2c2-43ae-8575-c377cc0b0495",
    "Br" : "e4504511-88b5-4b01-a537-e049f056668c",
    "Ca" : "ddbab0d1-b156-41bc-98e5-fb680285d7cd",
    "Cd" : "1111ac7e-20df-4ab4-9e02-57821894372c",
    "Cl" : "468e50e8-1960-4eba-bc1a-a9938a301694",
    "Co" : "2f7030b9-bafc-4b43-8504-deb8b5044130",
    "Cr" : "bca4bb32-f701-46bb-ba1e-bad477c19f7f",
    "Cu" : "e7451d8a-77af-44e0-86cf-ccd17ac84509",
    "F"  : "763a698f-54d7-4e2a-84a7-9cc8c0271b6a",
    "Fe" : "ebf21bca-b7cf-45d0-9d82-bfb80519a970",
    "Hg" : "a102e6f8-ebc7-450b-a39b-794be96558b7",
    "I"  : "e9164ff3-fd2d-4050-895d-0e0a42317be2",
    "K"  : "8b49eeb7-9caf-4101-b516-eb0aef30d530",
    "Mg" : "d26c0a60-86aa-41c8-80ee-3acabc4a5095",
    "Mn" : "8d27623b-147c-44e8-93cc-2183eac22991",
    "Mo" : "aa897226-0a91-40e5-aa05-4bae3b9e4213",
    "Na" : "7b656e1b-bc07-41cd-bad4-a5b51b6287da",
    "Ni" : "8b574e85-ff07-46bf-a753-f1271299dcf7",
    "Pb" : "71bc04b9-abfe-4f30-ab8f-ba654c7ad296",
    "Sb" : "3759d833-560a-4dbb-949e-afc63c0ade26",
    "Sc" : "1325d7f9-2fe2-4226-9304-ad9e5371e08f",
    "Se" : "c35265a9-fd3e-468c-af8e-f4e020c38fc0",
    "Si" : "67065577-4705-4ece-a892-6dd1d7ecd1e5",
    "Sn" : "ff888459-10c3-4700-afce-3a024aaf89cf",
    "Sr" : "d574cc22-07f2-4202-b564-1116ab197692",
    "Ti" : "abc78955-bd5f-4b1a-9607-0448dd75ebf2",
    "Tl" : "79baac3d-9e62-45ef-8f41-440dea32f11f",
    "V"  : "0b686a86-c506-4ad3-81fd-c3f39f05247d",
    "W"  : "058d6d50-172b-4a8a-97da-0cee759eca7d",
    "Zn" : "6cc518c8-4769-40df-b2cf-03f9fe00b759",
  },
  water_emissions:{
    "COD": "fc0b5c85-3b49-42c2-a3fd-db7e57b696e3",
    "BOD": "70d467b6-115e-43c5-add2-441de9411348",
    "TSS": "3844f446-ded5-4727-8421-17a00ef4eba7", //"Suspended solids, unspecified" (TSS discharged in the tool)

    "TKN": "ae70ca6c-807a-482b-9ddc-e449b4893fe3", //Nitrogen
    "NH4": "13331e67-6006-48c4-bdb4-340c12010036", //NH4 discharged
    "NO2": "0017271e-7df5-40bc-833a-36110c1fe5d5", //zero
    "NO3": "7ce56135-2ca5-4fba-ad52-d62a34bfeb35", //NOx effluent
    "ON":  "d43f7827-b47b-4652-8366-f370995fd206", //ON discharged
    "TP":  "b2631209-8374-431e-b7d5-56c96c6b6d79", //Phosphorus
    "PO4": "1727b41d-377e-43cd-bc01-9eaba946eccb", //PO4

    "Cr":  "8216fc31-15a1-4d33-858f-e09650b14c63", //chromium VI, emissions from WWTP and from CSO
    "Ag":  "af9793ba-25a1-4928-a14a-4bcf7d5bd3f7", //silver ion
    "Al":  "97e498ec-f323-4ec6-bcc0-d8a4c853bae3", //Aluminium
    "As":  "8c8ffaa5-84ed-4668-ba7d-80fd0f47013f", //Arsenic,_ion
    "B":   "94e22edc-fe4b-4bab-9a09-a081595389cc", //Boron
    "Ba":  "2c872773-0a29-4831-93b9-d49b116fa7d5", //Barium
    "Be":  "276e755c-ed57-466a-b555-4658c791f385", //Beryllium
    "Br":  "bac53020-1fed-4119-9242-33e4a2597560", //Bromine
    "Ca":  "ac066c02-b403-407b-a1f0-b29ad0f8188f", //Calcium,_ion
    "Cd":  "af83b42f-a4e6-4457-be74-46a87798f82a", //Cadmium,_ion
    "Cl":  "ce312691-69ee-4cdb-9bd6-f717955b94b8", //Chlorine
    "Co":  "d4291dd5-dae8-47fa-bf06-466fcecbc210", //Cobalt
    "Cu":  "6d9550e2-e670-44c1-bad8-c0c4975ffca7", //Copper,_ion
    "F":   "00d2fef1-e4d4-4a16-8e81-b8cc514e4c25", //Fluoride
    "Fe":  "7c335b9c-a403-47a8-bb6d-2e7d3c3a230e", //Iron,_ion
    "Hg":  "66bfb434-78ab-4183-b1a7-7f87d08974fa", //Mercury
    "I":   "e6360e00-79a2-455e-ac9d-2e3159736771", //Iodide
    "K":   "1653bf60-f682-4088-b02d-6dc44eae2786", //Potassium,_ion
    "Mg":  "7bdab722-11d0-4c42-a099-6f9ed510a44a", //Magnesium
    "Mn":  "f532985c-90b7-46fc-aac9-b039b40e22f1", //Manganese
    "Mo":  "442511cc-a98b-4242-9229-5736cb9a9399", //Molybdenum
    "Na":  "1fc409bc-b8e7-48b2-92d5-2ced4aa7bae2", //Sodium,_ion
    "Ni":  "9798359e-a3ee-4362-a038-23a188582c6e", //Nickel,_ion
    "Pb":  "b3ebdcc3-c588-4997-95d2-9785b26b34e1", //Lead
    "Sb":  "34b96163-a3df-4bc1-8224-e2a9fe01b23f", //Antimony
    "Sc":  "2f6bb945-2e93-4ea8-b3b6-7930c3680486", //Scandium
    "Se":  "544dbea9-1d18-44ff-b92b-7866e3baa6dd", //Selenium
    "Si":  "fc2371dc-5bff-41f6-a155-697fbf727b56", //Silicon
    "Sn":  "3ddb2e36-bc1b-43a5-8ef4-cbcdbeeeea70", //Tin,_ion
    "Sr":  "4295ed5b-9824-4bbf-97a4-fc4cabd87f0d", //Strontium
    "Ti":  "ff36578b-f403-4656-b934-81d8d4e02dc8", //Titanium,_ion
    "Tl":  "d9008a06-991c-4acc-a33e-5483ffd2491e", //Thallium
    "V":   "a46a250e-297d-43e9-b1c4-052cdcfb79c5", //Vanadium,_ion
    "W":   "7673fea9-b4ab-403e-b011-f1fb5a74ea2a", //Tungsten
    "Zn":  "541b633c-17a3-4047-bce6-0c0e4fdb7c10", //Zinc,_ion
  },
  air_emissions:{
    "CO2_fossil":                     "f9749677-9c9f-4678-ab55-c607dfdc2cb9", //CO2,_fossil
    "CO2_biogenic":                   "73ed05cc-9727-4abf-9516-4b5c0fe54a16", //CO2,_non-fossil
    "CO2_from_soil_or_biomass_stock": "e8787b5e-d927-446d-81a9-f56977bbfeb4", //CO2,_from_soil_or_biomass_stock

    "CH4_fossil":                     "5f7aad3d-566c-4d0d-ad59-e765f971aa0f", //CH4,_fossil
    "CH4_from_soil_or_biomass_stock": "299c6564-426e-48c3-b516-fdf301d12127", //CH4,_from_soil_or_biomass_stock
    "CH4_non-fossil":                 "baf58fc9-573c-419c-8c16-831ac03203b9", //CH4,_non-fossil
    "CH4":                            "b53d3744-3629-4219-be20-980865e54031", //CH4

    "NOx":                            "d068f3e2-b033-417b-a359-ca4f25da9731", //NOx
    "N2O":                            "6dc1b46f-ee89-4495-95c4-b8a637bcd6cb", //N2O
    "P":                              "198ce8e3-f05a-4bec-9f7f-325347453326", //Phosphorus
  },
  sludge_emissions:{
    //dry sludge composition
    'C_fossil'                :  'c74c3729-e577-4081-b572-a283d2561a75',
    'C_biogenic'              :  '6393c14b-db78-445d-a47b-c0cb866a1b25',
    'H'                       :  '2d23d1bb-e137-4ade-83fc-fbd0421e6cd5',
    'O'                       :  'dbf41b1b-c7b8-4d5e-b39c-f858eb868df5',
    'N'                       :  'f53a5dbc-3bd3-4570-adff-b00790ea3ffc',
    'S'                       :  'f6c7ebbb-902a-412f-a55b-0743aea00238',
    'P'                       :  '97f3bbfe-fa3a-4d05-9cb6-bb4b6379c5ef',

    //water
    'H2O'                     :  'a9358458-9724-4f03-b622-106eda248916',
    'water'                   :  'a9358458-9724-4f03-b622-106eda248916',

    'Organic_Carbon_of_soil'  :  '044617f2-c1d4-4592-94c6-bb325139e231',
    'AlOH'                    :  '66f07cc8-9cb2-4518-9042-9a72b4ac1d0c',

    'Ag'                      :  '56f09738-8225-4bdc-91d2-39ee6328f0ee',
    'Tl'                      :  '608190bf-8f74-4f8e-8544-f25377accf4d',
    'Zn'                      :  '33f96fe7-39da-47ca-837f-f2c311681d1b',
    'Ti'                      :  'e9fa11a1-1011-421d-aa34-0544d767a632',
    'Cd'                      :  'ad7781c7-5dc2-4421-b182-e1fd4cef7fa5',
    'Cr'                      :  'e1d2c19b-3a97-4f52-a83f-fe88400452c2',
    'Co'                      :  '66e996b5-5f7b-449f-8893-0b787af21d7e',
    'Mo'                      :  '83f67a9e-bf78-4e0d-b1f0-5051a1fda9fe',
    'Al'                      :  'e9688cbc-7400-457a-a936-5ab123ea326c',
    'Hg'                      :  '2a256b0b-6003-4669-a3c1-1d3eba2de45e',
    'Ba'                      :  '1dcfb203-7830-40b2-878d-13fc02a74051',
    'Se'                      :  '7e83fd10-c04d-4a80-8df2-a8bbcc268c4a',
  }
};
