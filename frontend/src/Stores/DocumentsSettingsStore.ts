import { defineStore } from 'pinia';
import { Doctypes } from '@/Interfaces/Documents/Doctypes.ts';
import { ErrorResponse } from '@/Interfaces/Requests.ts';
import {
	createDoctypes,
	deleteDoctypes,
	getAllDoctypes,
	getOneDoctypes,
	updateDoctypes,
} from '@/Services/DataLayers/Doctype.ts';

export const useDocumentsSettingsStore = defineStore('documentsSettings', {
	state: (): {
		allDoctypes: Doctypes[];
		doctypes: Doctypes | null;		
	} => ({
		allDoctypes: [],
		doctypes: null,
	}),
	getters: {
		getCurrentDoctypes(): Doctypes | null {
			return this.doctypes;
		},
	},
	actions: {
		async getOneDoctypes(id: number): Promise<Doctypes | null> {
			const doctypes: Doctypes | ErrorResponse = await getOneDoctypes(id);
			if ('error' in doctypes) {
				return null;
			} else {
				this.doctypes = doctypes;
				return doctypes;
			}
		},
		async getAllDoctypes(): Promise<Doctypes[]> {
			const doctypes: Doctypes[] | ErrorResponse = await getAllDoctypes();
			console.log("dt " + doctypes)
			if ('error' in doctypes) {
				return [];
			} else {
				this.allDoctypes = doctypes;
				return doctypes;
			}
		},
		async createDoctypes(
			name: string,
			description?: string,
		): Promise<Doctypes | null> {
			const doctypes: Doctypes | ErrorResponse = await createDoctypes(
				name,
				description,
			);
			if ('error' in doctypes) {
				return null;
			} else {
				this.doctypes = doctypes;
				return doctypes;
			}
		},
		async updateDoctypes(
			id: number,
			name: string,
			description?: string,
		): Promise<Doctypes | null> {
			const doctypes: Doctypes | ErrorResponse = await updateDoctypes(
				id,
				name,
				description,
			);
			if ('error' in doctypes) {
				return null;
			} else {
				this.doctypes = doctypes;
				return doctypes;
			}
		},		
		async deleteDoctypes(id: number): Promise<boolean> {
			const deletedDoctypes: Doctypes | ErrorResponse = await deleteDoctypes(id);
			if ('error' in deletedDoctypes) {
				return false;
			} else {
				// on rafraichit la liste des especes pour qu'elle ne contienne plus l'espece supprimee
				this.allDoctypes = this.allDoctypes.filter(
					(doctypes: Doctypes) => doctypes.id !== id,
				);
				return true;
			}
		},
	},
});
