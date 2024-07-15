import { defineStore } from 'pinia';
import { Association } from '@/Interfaces/Associations.ts';
import {
	createAssociation,
	getAssociation,
	getAssociations,
	updateAssociation,
} from '@/Services/DataLayers/Association.ts';
import { ErrorResponse } from '@/Interfaces/Requests.ts';

export const useAssociationsStore = defineStore('associations', {
	state: (): {
		associations: Association[];
		association: Association | null;
		isLoading: boolean;
	} => ({
		associations: [],
		association: null,
		isLoading: false,
	}),
	actions: {
		async getAssociation(id: number): Promise<Association | null> {
			const association: Association | ErrorResponse = await getAssociation(id);
			if ('error' in association) {
				return null;
			} else {
				this.association = association;
				return association;
			}
		},
		async getAssociations(): Promise<Association[]> {
			this.isLoading = true;
			const associations: Association[] | ErrorResponse =
				await getAssociations();
			this.isLoading = false;
			if ('error' in associations) {
				return [];
			} else {
				this.associations = associations;
				return associations;
			}
		},
		async createAssociation(
			association: Association,
		): Promise<Association | null> {
			const newAssociation: Association | ErrorResponse =
				await createAssociation(association);
			if ('error' in newAssociation) {
				return null;
			} else {
				this.associations.push(newAssociation);
				return newAssociation;
			}
		},
		async updateAssociation(
			association: Association,
		): Promise<Association | null> {
			const updatedAssociation: Association | ErrorResponse =
				await updateAssociation(association);
			if ('error' in updatedAssociation) {
				return null;
			} else {
				this.associations.push(updatedAssociation);
				return updatedAssociation;
			}
		},
	},
});
