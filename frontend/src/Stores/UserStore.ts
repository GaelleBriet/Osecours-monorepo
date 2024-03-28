import { defineStore } from 'pinia';
import { User } from '@/Interfaces/User.ts';
import { getUsers, login } from '@/Services/DataLayers/User.ts';
import {
	getFromStorage,
	setToStorage,
} from '@/Services/Helpers/LocalStorage.ts';

export const useUserStore = defineStore({
	id: 'user',
	state: (): {
		users: User[];
		user: User | null;
		isLoggedIn: unknown;
	} => ({
		users: [],
		user: null,
		isLoggedIn: getFromStorage('userLoggedIn') || false,
	}),

	getters: {
		totalUsers(): number {
			return this.users.length;
		},
		getCurrentUser(): User | null {
			return this.user;
		},
	},
	actions: {
		async getAllUsers(): Promise<User[]> {
			this.users = await getUsers();
			return this.users;
		},
		async loginUser(email: string, password: string): Promise<User> {
			const user: Partial<User> = await login(email, password);
			if (user) {
				this.user = user;
				this.isLoggedIn = true;
				setToStorage('userLoggedIn', true);
			}
			return user as User;
		},
	},
});
