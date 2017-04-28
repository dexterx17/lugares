<?php

use Illuminate\Database\Seeder;

use App\Categoria;


class CategoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$types=[
    		"accounting",
		    "airport",
		    "amusement_park",
		    "aquarium",
		    "art_gallery",
		    "atm",
		    "bakery",
		    "bank",
		    "bar",
		    "beauty_salon",
		    "bicycle_store",
		    "book_store",
		    "bowling_alley",
		    "bus_station",
		    "cafe",
		    "campground",
		    "car_dealer",
		    "car_rental",
		    "car_repair",
		    "car_wash",
		    "casino",
		    "cemetery",
		    "church",
		    "city_hall",
		    "clothing_store",
		    "convenience_store",
		    "courthouse",
		    "dentist",
		    "department_store",
		    "doctor",
		    "electrician",
		    "electronics_store",
		    "embassy",
		    "establishment (dejó de estar disponible)",
		    "finance (dejó de estar disponible)",
		    "fire_station",
		    "florist",
		    "food (dejó de estar disponible)",
		    "funeral_home",
		    "furniture_store",
		    "gas_station",
		    "general_contractor (dejó de estar disponible)",
		    "grocery_or_supermarket (dejó de estar disponible)",
		    "gym",
		    "hair_care",
		    "hardware_store",
		    "health (dejó de estar disponible)",
		    "hindu_temple",
		    "home_goods_store",
		    "hospital",
		    "insurance_agency",
		    "jewelry_store",
		    "laundry",
		    "lawyer",
		    "library",
		    "liquor_store",
		    "local_government_office",
		    "locksmith",
		    "lodging",
		    "meal_delivery",
		    "meal_takeaway",
		    "mosque",
		    "movie_rental",
		    "movie_theater",
		    "moving_company",
		    "museum",
		    "night_club",
		    "painter",
		    "park",
		    "parking",
		    "pet_store",
		    "pharmacy",
		    "physiotherapist",
		    "place_of_worship (dejó de estar disponible)",
		    "plumber",
		    "police",
		    "post_office",
		    "real_estate_agency",
		    "restaurant",
		    "roofing_contractor",
		    "rv_park",
		    "school",
		    "shoe_store",
		    "shopping_mall",
		    "spa",
		    "stadium",
		    "storage",
		    "store",
		    "subway_station",
		    "synagogue",
		    "taxi_stand",
		    "train_station",
		    "transit_station",
		    "travel_agency",
		    "university",
		    "veterinary_care",
		    "zoo"
    	];

    	$names = [
    		"contabilidad",
			"aeropuerto",
			"parque de atracciones",
			"acuario",
			"galería de arte",
			"Cajero automático",
			"panadería",
			"banco",
			"bar",
			"salón de belleza",
			"Tienda de bicicletas",
			"librería",
			"bolera",
			"estación de autobuses",
			"cafetería",
			"terreno de camping",
			"vendedor de autos",
			"alquiler de coches",
			"reparación de autos",
			"Lavado de coches",
			"casino",
			"cementerio",
			"Iglesia",
			"Palacio Municipal",
			"tienda de ropa",
			"Tienda de conveniencia",
			"palacio de justicia",
			"dentista",
			"grandes almacenes",
			"doctor",
			"electricista",
			"Tienda de electrónicos",
			"embajada",
			"Establecimiento (dejó de estar disponible)",
			"Finanzas (dejó de estar disponible)",
			"estación de bomberos",
			"florista",
			"Comida (dejó de estar disponible)",
			"casa funeraria",
			"tienda de muebles",
			"gasolinera",
			"General_contractor (dejó de estar disponible)",
			"Grocery_or_supermarket (dejó de estar disponible)",
			"gimnasio",
			"cuidado del cabello",
			"ferretería",
			"Salud (dejó de estar disponible)",
			"templo hindú",
			"Home_goods_store",
			"hospital",
			"agencia de seguros",
			"joyería",
			"lavandería",
			"abogado",
			"biblioteca",
			"Tienda de licores",
			"Local_government_office",
			"cerrajero",
			"alojamiento",
			"Entrega de comida",
			"Comida para llevar",
			"mezquita",
			"Pelicula",
			"cine",
			"empresa de mudanzas",
			"museo",
			"Club nocturno",
			"pintor",
			"parque",
			"estacionamiento",
			"tienda de mascotas",
			"farmacia",
			"fisioterapeuta",
			"Place_of_worship (dejó de estar disponible)",
			"fontanero",
			"policía",
			"oficina postal",
			"Real_estate_agency",
			"restaurante",
			"Contratista de techos",
			"Rv_park",
			"colegio",
			"Tienda de zapatos",
			"centro comercial",
			"spa",
			"estadio",
			"almacenamiento",
			"almacenar",
			"estación de metro",
			"sinagoga",
			"parada de taxi",
			"estación de tren",
			"Transit_station",
			"agencia de viajes",
			"Universidad",
			"cuidado veterinario",
			"Zoo"
    	];

    	for ($i=0; $i < count($types) ; $i++) { 
	        factory(Categoria::class)->create(['nombre'=>ucfirst($names[$i]),'categoria'=>$types[$i]]);
    	}
    }
}