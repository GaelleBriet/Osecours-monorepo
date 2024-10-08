export const animalHealthMock = {
	id: 51,
	name: 'Cujo',
	// description: null,
	// birth_date: null,
	// cats_friendly: null,
	// dogs_friendly: null,
	// children_friendly: null,
	// age: null,
	// behavioral_comment: null,
	// sterilized: null,
	// deceased: false,
	// breed_id: null,
	// specie_id: 1,
	// gender_id: null,
	// color_id: null,
	// coat_id: null,
	// sizerange_id: null,
	// agerange_id: null,
	identification: {
		id: 41,
		date: '2024-04-19',
		type: 'tatoo',
		number: '325874',
		animal_id: 51,
		created_at: '2024-04-19T08:42:31.000000Z',
		updated_at: '2024-04-19T08:42:31.000000Z',
	},
	breed: 'Saint-Bernard',
	specie: {
		name: 'Dog',
		id: 2,
	},
	// gender: null,
	// color: null,
	// coat: null,
	// sizerange: null,
	// agerange: null,
	// created_at: '2024-04-19T08:42:31.000000Z',
	// updated_at: '2024-04-19T08:42:31.000000Z',
	// deleted_at: null,
	health: [
		{
			id: 25,
			date: new Date('2024-04-19'),
			report: 'examen de routine',
			weight: 5,
			size: 30,
			animal_id: 51,
			document_id: null,
			created_at: '2024-04-19T08:42:31.000000Z',
			updated_at: '2024-04-19T08:42:31.000000Z',
		},
		{
			id: 26,
			date: new Date('2024-05-20'),
			report: 'examen de suivi',
			weight: 5.2,
			size: 30,
			animal_id: 51,
			document_id: null,
			created_at: '2024-05-20T08:42:31.000000Z',
			updated_at: '2024-05-20T08:42:31.000000Z',
		},
	],
	vaccines: [
		{
			id: 1,
			name: 'CHPPiL4/DHPP',
			date: new Date('2023-01-15'),
			description:
				'Distemper, Hépatite, Parvovirus, Parainfluenza, Leptospirose (CHPPiL4 inclut la Leptospirose)',
		},
		{
			id: 5,
			name: 'RABIES',
			date: new Date('2023-02-20'),
			description: 'Rage',
		},
	],
};
