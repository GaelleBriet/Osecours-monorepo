export interface Animal {
	id: number;
	name: string;
	description: string;
	birthdate: Date | string;
	catsFriendly: boolean;
	dogsFriendly: boolean;
	childrenFriendly: boolean;
	age?: number;
	ageRange: string;
	behavioralComment: string;
	sterilized: boolean;
	deceased: boolean;
	species: string;
	breed: string;
	status: string;
	icad: string;
	size: string;
}
