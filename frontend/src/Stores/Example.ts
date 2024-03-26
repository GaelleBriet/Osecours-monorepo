import { defineStore } from 'pinia';
import {
	getUser,
	getUsers,
	createUser,
} from '@/Services/DataLayers/Example.ts';
import { User } from '@/Interfaces/Example.ts';

export const useUserStore = defineStore('user', {
	state: (): { user: User | null; users: User[] } => ({
		user: null,
		users: [],
	}),
	getters: {
		totalUsers(): number {
			return this.users.length;
		},
	},
	actions: {
		async fetchUser(id: number) {
			this.user = await getUser(id);
		},
		async fetchUsers() {
			this.users = await getUsers();
		},
		async createNewUser(userData: User) {
			const newUser = await createUser(userData);
			this.users.push(newUser);
		},
	},
});
