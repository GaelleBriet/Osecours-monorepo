export interface Animal {
	id: number;
	name: string;
	description: string;
	birthdate: Date | string;
	catsFriendly: boolean;
	dogsFriendly: boolean;
	childrenFriendly: boolean;
	age: number;
	behavioralComment: string;
	sterilized: boolean;
	deceased: boolean;
}
