import { defineStore } from 'pinia';
import { User } from '@/Interfaces/User.ts';
import { getUsers } from '@/Services/DataLayers/User.ts';

export const useUserStore = defineStore({
	id: 'user',
	state: (): {
		isLoggedIn: boolean;
		users: User[];
	} => ({
		isLoggedIn: false,
		users: [],
	}),

	getters: {
		totalUsers(): number {
			return this.users.length;
		},
	},
	actions: {
		async fetchUsers(): Promise<User[]> {
			this.users = await getUsers();
			return this.users;
		},
		setLoggedIn(value: boolean) {
			this.isLoggedIn = value;
		},
	},
});
