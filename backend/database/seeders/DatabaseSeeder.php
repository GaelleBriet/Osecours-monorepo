<?php

namespace Database\Seeders;

use App\Enum\IdentificationTypeEnum;
use App\Enum\RoleEnum;
use App\Models\Address;
use App\Models\AgeRange;
use App\Models\Animal;
use App\Models\Association;
use App\Models\Breed;
use App\Models\City;
use App\Models\Coat;
use App\Models\Color;
use App\Models\Gender;
use App\Models\Healthcare;
use App\Models\Identification;
use App\Models\Person;
use App\Models\Role;
use App\Models\Shelter;
use App\Models\SizeRange;
use App\Models\Specie;
use App\Models\Status;
use App\Models\User;
use App\Models\Vaccine;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            CitiesSeeder::class,
            AssociationsSeeder::class,
            SpeciesSeeder::class,
            BreedsSeeder::class,
            ColorsSeeder::class,
            CoatsSeeder::class,
            SizeRangesSeeder::class,
            AgeRangesSeeder::class,
            VaccinesSeeder::class,
            StatusSeeder::class,
            GendersSeeder::class,
            AnimalsSeeder::class,
            IdentificationSeeder::class,
            HealthcareSeeder::class
        ]);
    }
}

//        $cityCreated = City::create(['name' => 'Dijon', 'zipcode' => '21000']);
//
//        $assocationsList = [
//            ['name' => 'Le refuge des chimères', 'address' => '123 rue des fantaisies'],
//            ['name' => 'larche de noé 2.0', 'address' => '10 place du désert'],
//            ['name' => 'quatres pattes et un toit', 'address' => '1 place de la tour Eiffel'],
//        ];
//
//        foreach ($assocationsList as $association) {
//
//            $associationCreated = Association::factory()->create(['name' => $association['name']]);
//
//            $shelterCreated = Shelter::create(['name' => $associationCreated->name, 'description' => $associationCreated->description, 'siret' => $associationCreated->siret]);
//
//            $associationCreated->shelters()->attach($shelterCreated->id, ['begin_date' => Date::now()]);
//            $personCreated = Person::create(['personable_id' => $associationCreated->id, 'personable_type' => get_class($associationCreated)]);
//            $addressCreated = Address::create(['street1' => $association['address'], 'city_id' => $cityCreated->id]);
//            $personCreated->addresses()->attach($addressCreated);
//
//            $associationCreated->person()->save($personCreated);
//            foreach (RoleEnum::cases() as $roleName) {
//                $emailReadyString = strtolower(Str::ascii($association['name']));
//                $emailReadyString = str_replace(' ', '', $emailReadyString);
//                $userCreated = User::factory()->create([
//                    'first_name' => ucfirst($roleName->value),
//                    'last_name' => ucfirst($roleName->value),
//                    'email' => $roleName->value.'-'.$emailReadyString.'@osecours.org',
//                ]);
//                Person::create(['personable_id' => $userCreated->id, 'personable_type' => get_class($userCreated)]);
//                $roleCreated = Role::firstOrCreate(
//                    ['name' => $roleName->value]
//                );
//                $associationCreated->users()->attach($userCreated->id, ['role_id' => $roleCreated->id]);
//            }
//        }

//
//        $dogbreeds = [
//            'Affenpinscher',
//            'Afghan Hound',
//            'Airedale Terrier',
//            'Akbash',
//            'Akita',
//            'Alaskan Malamute',
//            'American Bulldog',
//            'American Bully',
//            'American Eskimo Dog',
//            'American Foxhound',
//            'American Hairless Terrier',
//            'American Staffordshire Terrier',
//            'American Water Spaniel',
//            'Anatolian Shepherd',
//            'Appenzell Mountain Dog',
//            'Australian Cattle Dog / Blue Heeler',
//            'Australian Kelpie',
//            'Australian Shepherd',
//            'Australian Terrier',
//            'Basenji',
//            'Basset Hound',
//            'Beagle',
//            'Bearded Collie',
//            'Beauceron',
//            'Bedlington Terrier',
//            'Belgian Shepherd / Laekenois',
//            'Belgian Shepherd / Malinois',
//            'Belgian Shepherd / Sheepdog',
//            'Belgian Shepherd / Tervuren',
//            'Bernese Mountain Dog',
//            'Bichon Frise',
//            'Black and Tan Coonhound',
//            'Black Labrador Retriever',
//            'Black Mouth Cur',
//            'Black Russian Terrier',
//            'Bloodhound',
//            'Blue Lacy',
//            'Bluetick Coonhound',
//            'Boerboel',
//            'Bolognese',
//            'Border Collie',
//            'Border Terrier',
//            'Borzoi',
//            'Boston Terrier',
//            'Bouvier des Flandres',
//            'Boxer',
//            'Boykin Spaniel',
//            'Briard',
//            'Brittany Spaniel',
//            'Brussels Griffon',
//            'Bull Terrier',
//            'Bullmastiff',
//            'Cairn Terrier',
//            'Canaan Dog',
//            'Cane Corso',
//            'Cardigan Welsh Corgi',
//            'Carolina Dog',
//            'Catahoula Leopard Dog',
//            'Cattle Dog',
//            'Caucasian Sheepdog / Caucasian Ovtcharka',
//            'Cavalier King Charles Spaniel',
//            'Chesapeake Bay Retriever',
//            'Chihuahua',
//            'Chinese Crested Dog',
//            'Chinook',
//            'Chocolate Labrador Retriever',
//            'Chow Chow',
//            'Cirneco dell Etna',
//            'Clumber Spaniel',
//            'Cocker Spaniel',
//            'Collie',
//            'Coonhound',
//            'Corgi',
//            'Coton de Tulear',
//            'Curly-Coated Retriever',
//            'Dachshund',
//            'Dalmatian',
//            'Dandie Dinmont Terrier',
//            'Doberman Pinscher',
//            'Dogue de Bordeaux',
//            'Dutch Shepherd',
//            'English Bulldog',
//            'English Cocker Spaniel',
//            'English Coonhound',
//            'English Foxhound',
//            'English Pointer',
//            'English Setter',
//            'English Shepherd',
//            'English Springer Spaniel',
//            'English Toy Spaniel',
//            'Entlebucher',
//            'Eskimo Dog',
//            'Field Spaniel',
//            'Fila Brasileiro',
//            'Finnish Lapphund',
//            'Finnish Spitz',
//            'Flat-Coated Retriever',
//            'Fox Terrier',
//            'Foxhound',
//            'French Bulldog',
//            'Galgo Spanish Greyhound',
//            'German Pinscher',
//            'German Shepherd Dog',
//            'German Shorthaired Pointer',
//            'German Spitz',
//            'German Wirehaired Pointer',
//            'Giant Schnauzer',
//            'Glen of Imaal Terrier',
//            'Golden Retriever',
//            'Gordon Setter',
//            'Great Dane',
//            'Great Pyrenees',
//            'Greater Swiss Mountain Dog',
//            'Greyhound',
//            'Hamiltonstovare',
//            'Harrier',
//            'Havanese',
//            'Hovawart',
//            'Husky',
//            'Ibizan Hound',
//            'Icelandic Sheepdog',
//            'Irish Setter',
//            'Irish Terrier',
//            'Irish Water Spaniel',
//            'Irish Wolfhound',
//            'Italian Greyhound',
//            'Jack Russell Terrier',
//            'Japanese Chin',
//            'Jindo',
//            'Kai Dog',
//            'Karelian Bear Dog',
//            'Keeshond',
//            'Kerry Blue Terrier',
//            'Kishu',
//            'Klee Kai',
//            'Komondor',
//            'Kuvasz',
//            'Kyi Leo',
//            'Labrador Retriever',
//            'Lakeland Terrier',
//            'Lancashire Heeler',
//            'Leonberger',
//            'Lhasa Apso',
//            'Lowchen',
//            'Lurcher',
//            'Maltese',
//            'Manchester Terrier',
//            'Maremma Sheepdog',
//            'Mastiff',
//            'McNab',
//            'Miniature Bull Terrier',
//            'Miniature Dachshund',
//            'Miniature Pinscher',
//            'Miniature Poodle',
//            'Miniature Schnauzer',
//            'Mixed Breed',
//            'Morkie',
//            'Mountain Cur',
//            'Mountain Dog',
//            'Munsterlander',
//            'Neapolitan Mastiff',
//            'New Guinea Singing Dog',
//            'Newfoundland Dog',
//            'Norfolk Terrier',
//            'Norwegian Buhund',
//            'Norwegian Elkhound',
//            'Norwegian Lundehund',
//            'Norwich Terrier',
//            'Nova Scotia Duck Tolling Retriever',
//            'Old English Sheepdog',
//            'Otterhound',
//            'Papillon',
//            'Parson Russell Terrier',
//            'Patterdale Terrier / Fell Terrier',
//            'Pekingese',
//            'Pembroke Welsh Corgi',
//            'Peruvian Inca Orchid',
//            'Petit Basset Griffon Vendeen',
//            'Pharaoh Hound',
//            'Pit Bull Terrier',
//            'Plott Hound',
//            'Pointer',
//            'Polish Lowland Sheepdog',
//            'Pomeranian',
//            'Poodle',
//            'Portuguese Podengo',
//            'Portuguese Water Dog',
//            'Presa Canario',
//            'Pug',
//            'Puli',
//            'Pumi',
//            'Pyrenean Shepherd',
//            'Rat Terrier',
//            'Redbone Coonhound',
//            'Retriever',
//            'Rhodesian Ridgeback',
//            'Rottweiler',
//            'Rough Collie',
//            'Saint Bernard',
//            'Saluki',
//            'Samoyed',
//            'Sarplaninac',
//            'Schipperke',
//            'Schnauzer',
//            'Schnoodle',
//            'Scottish Deerhound',
//            'Scottish Terrier',
//            'Sealyham Terrier',
//            'Setter',
//            'Shar-Pei',
//            'Sheep Dog',
//            'Sheepadoodle',
//            'Shepherd',
//            'Shetland Sheepdog / Sheltie',
//            'Shiba Inu',
//            'Shih Tzu',
//            'Siberian Husky',
//            'Silky Terrier',
//            'Skye Terrier',
//            'Sloughi',
//            'Smooth Collie',
//            'Smooth Fox Terrier',
//            'South Russian Ovtcharka',
//            'Spaniel',
//            'Spanish Water Dog',
//            'Spinone Italiano',
//            'Spitz',
//            'Staffordshire Bull Terrier',
//            'Standard Poodle',
//            'Standard Schnauzer',
//            'Sussex Spaniel',
//            'Swedish Vallhund',
//            'Tennessee Treeing Brindle',
//            'Terrier',
//            'Thai Ridgeback',
//            'Tibetan Mastiff',
//            'Tibetan Spaniel',
//            'Tibetan Terrier',
//            'Tosa Inu',
//            'Toy Fox Terrier',
//            'Toy Manchester Terrier',
//            'Treeing Walker Coonhound',
//            'Vizsla',
//            'Weimaraner',
//            'Welsh Springer Spaniel',
//            'Welsh Terrier',
//            'West Highland White Terrier / Westie',
//            'Wheaten Terrier',
//            'Whippet',
//            'White German Shepherd',
//            'Wire Fox Terrier',
//            'Wirehaired Dachshund',
//            'Wirehaired Pointing Griffon',
//            'Wirehaired Terrier',
//            'Xoloitzcuintli / Mexican Hairless',
//            'Yellow Labrador Retriever',
//            'Yorkshire Terrier',
//        ];
//
//        $catbreeds = [
//            'Abyssinian',
//            'American Bobtail',
//            'American Curl',
//            'American Shorthair',
//            'American Wirehair',
//            'Applehead Siamese',
//            'Balinese',
//            'Bengal',
//            'Birman',
//            'Bombay',
//            'British Shorthair',
//            'Burmese',
//            'Burmilla',
//            'Canadian Hairless',
//            'Chartreux',
//            'Chausie',
//            'Cornish Rex',
//            'Cymric',
//            'Devon Rex',
//            'Domestic',
//            'Egyptian Mau',
//            'Exotic Shorthair',
//            'Havana',
//            'Himalayan',
//            'Japanese Bobtail',
//            'Javanese',
//            'Korat',
//            'LaPerm',
//            'Maine Coon',
//            'Manx',
//            'Munchkin',
//            'Nebelung',
//            'Norwegian Forest Cat',
//            'Ocicat',
//            'Oriental Long Hair',
//            'Oriental Short Hair',
//            'Persian',
//            'Pixiebob',
//            'Ragamuffin',
//            'Ragdoll',
//            'Russian Blue',
//            'Scottish Fold',
//            'Selkirk Rex',
//            'Siamese',
//            'Siberian',
//            'Singapura',
//            'Snowshoe',
//            'Somali',
//            'Sphynx / Hairless Cat',
//            'Tonkinese',
//            'Turkish Angora',
//            'Turkish Van',
//        ];
//
//        $dogColors = [
//            'Apricot',
//            'Beige',
//            'Bicolor',
//            'Black',
//            'Brindle',
//            'Brown',
//            'Chocolate',
//            'Golden',
//            'Gray',
//            'Blue',
//            'Silver',
//            'Harlequin',
//            'Merle (Blue)',
//            'Merle (Red)',
//            'Red',
//            'Chestnut',
//            'Orange',
//            'Sable',
//            'Tricolor (Brown, Black, & White)',
//            'White',
//            'Cream',
//            'Yellow',
//        ];
//
//        $catColors = [
//            'Tan',
//            'Blond',
//            'Fawn',
//            'Black',
//            'Black & White / Tuxedo',
//            'Blue Cream',
//            'Blue Point',
//            'Buff & White',
//            'Buff',
//            'Tan',
//            'Fawn',
//            'Calico',
//            'Chocolate Point',
//            'Cream',
//            'Ivory',
//            'Cream Point',
//            'Dilute Calico',
//            'Dilute Tortoiseshell',
//            'Flame Point',
//            'Gray & White',
//            'Lilac Point',
//            'Orange & White',
//            'Orange',
//            'Red',
//            'Seal Point',
//            'Smoke',
//            'Tabby (Brown / Chocolate)',
//            'Tabby (Buff / Tan / Fawn)',
//            'Tabby (Gray / Blue / Silver)',
//            'Tabby (Leopard / Spotted)',
//            'Tabby (Orange / Red)',
//            'Tabby (Tiger Striped)',
//            'Torbie',
//            'Tortoiseshell',
//            'White',
//        ];

//        $colors = array_unique(array_merge($catColors, $dogColors));
//
//        foreach ($colors as $color) {
//            $colorCreated = Color::factory()->create([
//                'name' => ucfirst($color),
//                'description' => '',
//            ]);
//        }

        $dogCoats = [
            'Hairless',
            'Short',
            'Medium',
            'Long',
            'Wire',
            'Curly',
        ];

        $catCoats = [
            'Hairless',
            'Short',
            'Medium',
            'Long',
        ];

//        $coats = array_unique(array_merge($catCoats, $dogCoats));
//
//        foreach ($coats as $coat) {
//            $coatCreated = Coat::factory()->create([
//                'name' => ucfirst($coat),
//                'description' => '',
//            ]);
//        }

//        foreach ($species as $specie) {
//            if ($specie == 'Cat') {
//                $specieCreated = Specie::factory()->create([
//                    'name' => ucfirst($specie),
//                    'description' => '',
//                ]);
//                foreach ($catbreeds as $catbreed) {
//                    $catbreedCreated = Breed::factory()->create([
//                        'name' => ucfirst($catbreed),
//                        'description' => '',
//                        'specie_id' => $specieCreated->id,
//                    ]);
//                }
//                foreach ($catCoats as $catcoat) {
//                    $coatBounded = Coat::where('name', $catcoat)->first();
//                    $specieCreated->coats()->syncWithoutDetaching($coatBounded);
//                }
//                foreach ($catColors as $catcolor) {
//                    $colorBounded = Color::where('name', $catcolor)->first();
//                    $specieCreated->colors()->syncWithoutDetaching($colorBounded);
//                }
//            } elseif ($specie == 'Dog') {
//                $specieCreated = Specie::factory()->create([
//                    'name' => ucfirst($specie),
//                    'description' => '',
//                ]);
//
//                foreach ($dogbreeds as $dogbreed) {
//                    $dogbreedCreated = Breed::factory()->create([
//                        'name' => ucfirst($dogbreed),
//                        'description' => '',
//                        'specie_id' => $specieCreated->id,
//                    ]);
//                }
//                foreach ($dogCoats as $dogcoat) {
//                    $coatBounded = Coat::where('name', $dogcoat)->first();
//                    $specieCreated->coats()->syncWithoutDetaching($coatBounded);
//                }
//                foreach ($dogColors as $dogcolor) {
//                    $colorBounded = Color::where('name', $dogcolor)->first();
//                    $specieCreated->colors()->syncWithoutDetaching($colorBounded);
//                }
//            }
//        }
//
//        $sizeRanges = [
//            'Small',
//            'Average',
//            'Big',
//            'Molosse',
//        ];
//
//        foreach ($sizeRanges as $size) {
//            $sizeCreated = SizeRange::factory()->create([
//                'name' => ucfirst($size),
//                'description' => '',
//            ]);
//        }
//
//        $ageRanges = [
//            'Baby',
//            'Junior',
//            'Adult',
//            'Senior',
//        ];
//
//        foreach ($ageRanges as $age) {
//            $ageCreated = AgeRange::factory()->create([
//                'name' => ucfirst($age),
//                'description' => '',
//            ]);
//        }
//
//        $vaccines = [
//            ['specie' => 'Dog', 'name' => 'CHPPiL4/DHPP', 'description' => 'Distemper, Hépatite, Parvovirus, Parainfluenza, Leptospirose (CHPPiL4 inclut la Leptospirose)'],
//            ['specie' => 'Dog', 'name' => 'LEPTOSPIROSIS', 'description' => 'Leptospirose (si pas inclus dans CHPPiL4)'],
//            ['specie' => 'Dog', 'name' => 'BORDETELLA/INFLUENZA', 'description' => 'Bordetella bronchiseptica (agent principal de la toux du chenil), Influenza Canine (grippe canine)'],
//            ['specie' => 'Cat', 'name' => 'BORDETELLA/INFLUENZA', 'description' => 'Bordetella bronchiseptica (agent principal de la toux du chenil), Influenza Canine (grippe canine)'],
//            ['specie' => 'Dog', 'name' => 'LYME', 'description' => 'Maladie de Lyme'],
//            ['specie' => 'Dog', 'name' => 'RABIES', 'description' => 'Rage'],
//            ['specie' => 'Cat', 'name' => 'RABIES', 'description' => 'Rage'],
//            ['specie' => 'Cat', 'name' => 'FVRCP/RCP', 'description' => 'Rhinotrachéite (herpès type1, coryza), Calicivirus, Panleucopénie'],
//            ['specie' => 'Cat', 'name' => 'FeLV', 'description' => 'Leucose Féline (immunodéficience, cancers…)'],
//            ['specie' => 'Cat', 'name' => 'CHLAMYDOPHILA', 'description' => 'Chlamydophila felis (bactérie, conjonctivite, symptômes respiratoires)'],
//        ];
//
//        foreach ($vaccines as $vaccineData) {
//            $vaccineCreated = Vaccine::firstOrCreate(collect($vaccineData)->only(['name', 'description'])->toArray());
//            $specieBounded = Specie::where('name', $vaccineData['specie'])->first();
//            $vaccineCreated->species()->attach($specieBounded);
//        }

//        $statuses = [
//            'Found',
//            'Adoptable',
//            'Hosted',
//            'Adopted',
//            'Dead',
//        ];
//
//        foreach ($statuses as $status) {
//            $statusCreated = Status::factory()->create([
//                'name' => ucfirst($status),
//                'description' => '',
//            ]);
//        }
//
//        $genders = [
//            'Male',
//            'Female',
//            'Unknown',
//        ];
//
//        foreach ($genders as $gender) {
//            $genderCreated = Gender::factory()->create([
//                'name' => ucfirst($gender),
//                'description' => '',
//            ]);
//        }

//        $firstAnimal = Animal::create([
//            'name' => 'pepette',
//            'description' => 'petit chat',
//            'birth_date' => '2024-04-01',
//            'cats_friendly' => true,
//            'dogs_friendly' => true,
//            'children_friendly' => true,
//            'behavioral_comment' => 'adorable',
//            'sterilized' => false,
//            'sizerange_id' => 1,
//            'specie_id' => 1,
//        ]);
//        $secondAnimal = Animal::create([
//            'name' => 'Gurvan',
//            'description' => 'Warning',
//            'birth_date' => '2024-04-01',
//            'cats_friendly' => true,
//            'dogs_friendly' => true,
//            'children_friendly' => true,
//            'behavioral_comment' => 'Dangerous',
//            'sterilized' => false,
//            'sizerange_id' => 4,
//            'specie_id' => 2,
//        ]);
//        $thirdAnimal = Animal::create([
//            'name' => 'Biscuit',
//            'description' => 'Friendly dog',
//            'birth_date' => '2023-06-15',
//            'cats_friendly' => false,
//            'dogs_friendly' => true,
//            'children_friendly' => true,
//            'behavioral_comment' => 'Loves to play fetch',
//            'sterilized' => true,
//            'sizerange_id' => 3,
//            'specie_id' => 2,
//            'breed_id' => 98,
//        ]);
//        $fourthAnimal = Animal::create([
//            'name' => 'Whiskers',
//            'description' => 'Independent cat',
//            'birth_date' => '2022-01-01',
//            'cats_friendly' => true,
//            'dogs_friendly' => false,
//            'children_friendly' => false,
//            'behavioral_comment' => 'Prefers quiet environments',
//            'sterilized' => true,
//            'sizerange_id' => 1,
//            'specie_id' => 1,
//            'breed_id' => 29,
//        ]);
//
//        $numberChip = '555555555555555';
//        $numberChip2 = '123854769524159';
//        $numberChip3 = '123456789123456';
//        $numberTatoo = 'A45B56';
//
//        Identification::create([
//            'type' => IdentificationTypeEnum::CHIP->value,
//            'number' => $numberChip,
//            'date' => Date::now(),
//            'animal_id' => $firstAnimal->id,
//        ]);
//        Identification::create([
//            'type' => IdentificationTypeEnum::TATOO->value,
//            'number' => $numberTatoo,
//            'date' => Date::now(),
//            'animal_id' => $secondAnimal->id,
//        ]);
//        Identification::create([
//            'type' => IdentificationTypeEnum::CHIP->value,
//            'number' => $numberChip2,
//            'date' => Date::now(),
//            'animal_id' => $thirdAnimal->id,
//        ]);
//        Identification::create([
//            'type' => IdentificationTypeEnum::CHIP->value,
//            'number' => $numberChip3,
//            'date' => Date::now(),
//            'animal_id' => $fourthAnimal->id,
//        ]);
//
//        $healthcare = Healthcare::create([
//            'date' => Date::now(),
//            'report' => 'tout va bien',
//            'animal_id' => $firstAnimal->id,
//        ]);
//    }
