export interface Animal {
	id: number;
	name: string;
	description: string;
	birthdate: Date | string;
	catsFriendly: boolean;
	dogsFriendly: boolean;
	childrenFriendly: boolean;
	age?: number;
	ageRange: number;
	behavioralComment?: string;
	sterilized: boolean;
	deceased: boolean;
	species: number;
	breed: string;
	status: number;
	icad: string;
	size: number;
	color: string;
	coat: string;
	gender: number;
}
