import { defineStore } from 'pinia';
import { User } from '@/Interfaces/User.ts';
import { ErrorResponse } from '@/Interfaces/Requests.ts';
import {
	createMember,
	deleteMember,
	getMemberById,
	getMembers,
	getMembersByFamilyType,
	updateMember,
} from '@/Services/DataLayers/Member.ts';

export const useMembersStore = defineStore({
	id: 'members',
	state: (): {
		members: User[];
		member: User | null;
		adoptFamiliesCount: number;
		fosterFamiliesCount: number;
	} => ({
		members: [],
		member: null,
		adoptFamiliesCount: 0,
		fosterFamiliesCount: 0,
	}),
	getters: {
		membersQuantity(): number {
			return this.members.length;
		},
		adoptFamiliesQuantity(): number {
			return this.adoptFamiliesCount;
		},
		fosterFamiliesQuantity(): number {
			return this.fosterFamiliesCount;
		},
		getCurrentMember(): User | null {
			return this.member;
		},
	},
	actions: {
		async getMembers(): Promise<User[]> {
			const members: User[] | ErrorResponse = await getMembers();
			if ('error' in members) {
				return [];
			} else {
				this.members = members;
				return members;
			}
		},
		async getMemberById(id: string): Promise<User | null> {
			const member: User | ErrorResponse = await getMemberById(id);
			if ('error' in member) {
				return null;
			} else {
				this.member = member;
				return member;
			}
		},
		async getMembersByFamilyType(
			familyType: 'adopt' | 'foster',
			currentAssociationId: string,
		): Promise<User[]> {
			const families: User[] | ErrorResponse = await getMembersByFamilyType(
				familyType,
				currentAssociationId,
			);

			if ('error' in families) {
				return [];
			} else {
				this.members = families;
				if (familyType === 'adopt') {
					this.adoptFamiliesCount = families.length;
				} else if (familyType === 'foster') {
					this.fosterFamiliesCount = families.length;
				}

				return families;
			}
		},
		async getAllFamilies(): Promise<User[]> {
			const families: User[] | ErrorResponse = await getMembers();
			if ('error' in families) {
				return [];
			} else {
				const filteredFamilies: User[] = families.filter(
					(family) => family.adoptFamily || family.fosterFamily,
				);
				this.members = filteredFamilies;
				return filteredFamilies;
			}
		},
		async createMember(member: User): Promise<User> {
			const newMember: User | ErrorResponse = await createMember(member);
			if ('error' in newMember) {
				return {} as User;
			} else {
				this.members.push(newMember);
				return newMember;
			}
		},
		async updateMember(member: User): Promise<User> {
			const updatedMember: User | ErrorResponse = await updateMember(member);
			if ('error' in updatedMember) {
				return {} as User;
			} else {
				this.members = this.members.map((m: User) =>
					m.id === updatedMember.id ? updatedMember : m,
				);
				return updatedMember;
			}
		},
		async deleteMember(id: string): Promise<boolean> {
			const deletedMember: boolean = await deleteMember(id);
			if (deletedMember) {
				this.members = this.members.filter((m: User) => m.id !== id);
				return true;
			} else {
				return false;
			}
		},
	},
});
