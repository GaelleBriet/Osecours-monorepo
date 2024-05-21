import { defineStore } from 'pinia';
import { User, UserTokenScope } from '@/Interfaces/User.ts';
import { login, loginWithAssociation } from '@/Services/DataLayers/User.ts';
import {
	getFromStorage,
	removeFromStorage,
	setToStorage,
} from '@/Services/Helpers/LocalStorage.ts';
import { ErrorResponse } from '@/Interfaces/Requests.ts';

export const useUserStore = defineStore({
	id: 'user',
	state: (): {
		users: User[];
		user: User | null;
		isLoggedIn: boolean;
	} => ({
		users: [],
		user: getFromStorage('user') as User | null,
		isLoggedIn: Boolean(getFromStorage('userLoggedIn')),
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
		async loginUser(email: string, password: string): Promise<User> {
			if (!email || !password)
				throw new Error('Email and password are required.');
			const user: Partial<User> | ErrorResponse = await login(email, password);
			if (user) {
				this.user = user as User;
				setToStorage('user', this.user);
				return this.user;
			}
			return {} as User;
		},

		async loginWithAssociation(
			email: string,
			password: string,
			associationId: string,
			associationName: string,
		): Promise<User> {
			const userTokenScope: UserTokenScope | ErrorResponse =
				await loginWithAssociation(email, password, associationId);
			if ('token' in userTokenScope && userTokenScope.token) {
				this.user = {
					...this.user,
					token: userTokenScope.token,
					scopes: userTokenScope.scopes,
					email: email,
					associationName: associationName ? associationName : '',
					associationId: associationId ? associationId : '',
				};
				setToStorage('token', this.user.token);
				setToStorage('user', this.user);
				setToStorage('userLoggedIn', true);
				setToStorage('associationId', this.user.associationId);
				this.isLoggedIn = true;
			} else {
				throw new Error('No user found.');
			}
			return this.user;
		},

		async logoutUser(): Promise<void> {
			this.user = null;
			removeFromStorage('token');
			removeFromStorage('user');
			removeFromStorage('userLoggedIn');
			removeFromStorage('sheltersTabs');
			removeFromStorage('documentsTabs');
			removeFromStorage('animalsTabs');
			removeFromStorage('associationId');
			this.isLoggedIn = false;
		},
	},
});
