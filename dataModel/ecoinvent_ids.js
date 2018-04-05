//map between ecoinvent ids and this tool variable names
//can be inputs and outputs

/*
  "resources" folder: ecoinvent ids
    - properties.json            (ww activity + ww influent + sludge composition)
    - emissions_to_water.json
    - emissions_to_air.json
*/

var Ecoinvent_ids={

  //compounds not in the tool TBD
  "DOC"  : "efe22a60-b1a3-4b33-a5ba-4bf575e0a889",
  "TOC"  : "a547f885-601d-4d52-9bf9-60f0cef06269",
  "NO3"  : "4f461b9d-5a7b-4a46-8803-23f6df0dc522", // NOx ?
  "NO2"  : "c8ebc911-268a-4dfe-a426-73e1e35b587a", // NOx ?
  "TN"   : "f04a971d-f503-4ca0-b2b1-0ecd2e53ea61", // total nitrogen
  "sTKN" : null,                                   // missing id soluble TKN
  "TKN " : null,                                   // missing id total TKN
  "SO4"  : "1e4ef691-c7d3-49fc-9aee-6d77575a7b8a", // dissolved sulfate SO4 as S
  "pOS"  : "8175120e-a5b7-4f19-afca-5620e9e4dd8b", // particulate sulfur
  "TS"   : "7f3410da-b91e-40d8-9545-ab269ff66900", // sulfur

  //key components (inputs)
  "BOD" : "dd13a45c-ddd8-414d-821f-dfe31c7d2868",
  "COD" : "3f469e9e-267a-4100-9f43-4297441dc726",
  "NH4" : "f7fa53fa-ee5f-4a97-bcd8-1b0851afe9a6",
  "TP"  : "8e73d3fb-bb81-4c42-bfa6-8be4ff13125d",
  "PO4" : "7fe01cf6-6e7b-487f-b37e-32388640a8a4",

  //key components (calculated)
  "pON" : "88c9f622-8451-41aa-98b0-c56b191a7e0a",
  "sON" : "cbc4a2c2-1710-4e6c-9b90-e1e72819d7b9",
  "pOP" : "0f205308-d33a-430b-b3ec-b62bef311f2f",

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

};
