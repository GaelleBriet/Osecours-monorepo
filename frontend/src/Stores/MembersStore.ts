import { defineStore } from 'pinia';
import { User } from '@/Interfaces/User.ts';
import { ErrorResponse } from '@/Interfaces/Requests.ts';
import { Members } from '@/Interfaces/Members.ts';
import {
	createMember,
	deleteMember,
	getMemberById,
	getMemberRole,
	getMembers,
	getMembersByFamilyType,
	updateMember,
} from '@/Services/DataLayers/Member.ts';
import { Role } from '@/Enums/Role.ts';
import { RouteParamValue } from 'vue-router';

interface RoleId {
	role_id?: number;
}

export const useMembersStore = defineStore({
	id: 'members',
	state: (): {
		members: Members[];
		member: Members | null;
		adoptFamiliesCount: number;
		fosterFamiliesCount: number;
		isLoading: boolean;
	} => ({
		members: [],
		member: null,
		adoptFamiliesCount: 0,
		fosterFamiliesCount: 0,
		isLoading: false,
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
		async getMembers(associationId: string): Promise<Members[]> {
			this.isLoading = true;
			const members: Members[] | ErrorResponse =
				await getMembers(associationId);
			this.isLoading = false;
			if ('error' in members) {
				return [];
			} else {
				this.members = members;
				return members;
			}
		},
		async getMemberById(id: string | RouteParamValue[]): Promise<User | null> {
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
		): Promise<Members[]> {
			this.isLoading = true;
			const families: Members[] | ErrorResponse = await getMembersByFamilyType(
				familyType,
				currentAssociationId,
			);
			this.isLoading = false;

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
		async getMemberRole(
			memberId: number,
			associationId: number,
		): Promise<number | undefined> {
			const role: RoleId | ErrorResponse = await getMemberRole(
				memberId,
				associationId,
			);
			if ('error' in role) {
				return undefined;
			} else {
				return role.role_id;
			}
		},
		async getAllFamilies(associationId: string): Promise<Members[]> {
			this.isLoading = true;
			const families: Members[] | ErrorResponse =
				await getMembers(associationId);
			this.isLoading = false;

			if ('error' in families) {
				return [];
			} else {
				const filteredFamilies: Members[] = families.filter(
					(family) =>
						family?.pivot?.role_id === Role.ADOPTER ||
						family?.pivot?.role_id === Role.FOSTER,
				);
				this.members = filteredFamilies;
				return filteredFamilies;
			}
		},
		async createMember(member: Members): Promise<User> {
			const newMember: User | ErrorResponse = await createMember(member);
			if ('error' in newMember) {
				return {} as User;
			} else {
				this.members.push(newMember);
				return newMember;
			}
		},
		async updateMember(): Promise<User> {
			const updatedMember: User | ErrorResponse = await updateMember();
			if ('error' in updatedMember) {
				return {} as User;
			} else {
				this.members = this.members.map((m: User) =>
					m.id === updatedMember.id ? updatedMember : m,
				);
				return updatedMember;
			}
		},
		async deleteMember(id: number | undefined | string): Promise<boolean> {
			const deletedMember: Members | ErrorResponse = await deleteMember(id);
			if ('data' in deletedMember) {
				this.members = this.members.filter((m: Members) => m.id !== id);
				return true;
			} else {
				return false;
			}
		},
	},
});
