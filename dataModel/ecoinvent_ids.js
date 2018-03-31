//map between ecoinvent ids and this tool variable names
//can be inputs and outputs

var Ecoinvent_ids=[
  //compounds not in the tool
  {id:"NO3",  ecoinvent_id:"4f461b9d-5a7b-4a46-8803-23f6df0dc522"}, //TBD NOx ?
  {id:"NO2",  ecoinvent_id:"c8ebc911-268a-4dfe-a426-73e1e35b587a"}, //TBD NOx ?
  {id:"TN",   ecoinvent_id:"f04a971d-f503-4ca0-b2b1-0ecd2e53ea61"}, //TBD total nitrogen
  {id:"sTKN", ecoinvent_id:null,                                 }, //TBD missing id soluble TKN
  {id:"TKN ", ecoinvent_id:null,                                 }, //TBD missing id total TKN

  //key components (inputs)
  {id:"BOD", ecoinvent_id:"dd13a45c-ddd8-414d-821f-dfe31c7d2868"},
  {id:"COD", ecoinvent_id:"3f469e9e-267a-4100-9f43-4297441dc726"},
  {id:"NH4", ecoinvent_id:"f7fa53fa-ee5f-4a97-bcd8-1b0851afe9a6"},
  {id:"TP",  ecoinvent_id:"8e73d3fb-bb81-4c42-bfa6-8be4ff13125d"},
  {id:"PO4", ecoinvent_id:"7fe01cf6-6e7b-487f-b37e-32388640a8a4"},
  //key components (calculated variables)
  {id:"pON", ecoinvent_id:"88c9f622-8451-41aa-98b0-c56b191a7e0a"},
  {id:"sON", ecoinvent_id:"cbc4a2c2-1710-4e6c-9b90-e1e72819d7b9"},
  {id:"pOP", ecoinvent_id:"0f205308-d33a-430b-b3ec-b62bef311f2f"},

  //metals and other elements
  {id:"Ag", ecoinvent_id:"dcdc6c7b-0b72-4174-bc90-f51ed66426d5"},
  {id:"Al", ecoinvent_id:"77154d2e-4b05-48f2-a89a-789acd170497"},
  {id:"As", ecoinvent_id:"b321f120-4db7-4e7c-a196-82a231023052"},
  {id:"B" , ecoinvent_id:"c0447419-7139-44fe-a855-ea71e2b78585"},
  {id:"Ba", ecoinvent_id:"33976f6b-2575-4410-8f60-d421bdf3e554"},
  {id:"Be", ecoinvent_id:"d21c7c5c-b2c2-43ae-8575-c377cc0b0495"},
  {id:"Br", ecoinvent_id:"e4504511-88b5-4b01-a537-e049f056668c"},
  {id:"Ca", ecoinvent_id:"ddbab0d1-b156-41bc-98e5-fb680285d7cd"},
  {id:"Cd", ecoinvent_id:"1111ac7e-20df-4ab4-9e02-57821894372c"},
  {id:"Cl", ecoinvent_id:"468e50e8-1960-4eba-bc1a-a9938a301694"},
  {id:"Co", ecoinvent_id:"2f7030b9-bafc-4b43-8504-deb8b5044130"},
  {id:"Cr", ecoinvent_id:"bca4bb32-f701-46bb-ba1e-bad477c19f7f"},
  {id:"Cu", ecoinvent_id:"e7451d8a-77af-44e0-86cf-ccd17ac84509"},
  {id:"F" , ecoinvent_id:"763a698f-54d7-4e2a-84a7-9cc8c0271b6a"},
  {id:"Fe", ecoinvent_id:"ebf21bca-b7cf-45d0-9d82-bfb80519a970"},
  {id:"Hg", ecoinvent_id:"a102e6f8-ebc7-450b-a39b-794be96558b7"},
  {id:"I" , ecoinvent_id:"e9164ff3-fd2d-4050-895d-0e0a42317be2"},
  {id:"K" , ecoinvent_id:"8b49eeb7-9caf-4101-b516-eb0aef30d530"},
  {id:"Mg", ecoinvent_id:"d26c0a60-86aa-41c8-80ee-3acabc4a5095"},
  {id:"Mn", ecoinvent_id:"8d27623b-147c-44e8-93cc-2183eac22991"},
  {id:"Mo", ecoinvent_id:"aa897226-0a91-40e5-aa05-4bae3b9e4213"},
  {id:"Na", ecoinvent_id:"7b656e1b-bc07-41cd-bad4-a5b51b6287da"},
  {id:"Ni", ecoinvent_id:"8b574e85-ff07-46bf-a753-f1271299dcf7"},
  {id:"Pb", ecoinvent_id:"71bc04b9-abfe-4f30-ab8f-ba654c7ad296"},
  {id:"Sb", ecoinvent_id:"3759d833-560a-4dbb-949e-afc63c0ade26"},
  {id:"Sc", ecoinvent_id:"1325d7f9-2fe2-4226-9304-ad9e5371e08f"},
  {id:"Se", ecoinvent_id:"c35265a9-fd3e-468c-af8e-f4e020c38fc0"},
  {id:"Si", ecoinvent_id:"67065577-4705-4ece-a892-6dd1d7ecd1e5"},
  {id:"Sn", ecoinvent_id:"ff888459-10c3-4700-afce-3a024aaf89cf"},
  {id:"Sr", ecoinvent_id:"d574cc22-07f2-4202-b564-1116ab197692"},
  {id:"Ti", ecoinvent_id:"abc78955-bd5f-4b1a-9607-0448dd75ebf2"},
  {id:"Tl", ecoinvent_id:"79baac3d-9e62-45ef-8f41-440dea32f11f"},
  {id:"V" , ecoinvent_id:"0b686a86-c506-4ad3-81fd-c3f39f05247d"},
  {id:"W" , ecoinvent_id:"058d6d50-172b-4a8a-97da-0cee759eca7d"},
  {id:"Zn", ecoinvent_id:"6cc518c8-4769-40df-b2cf-03f9fe00b759"},
];
