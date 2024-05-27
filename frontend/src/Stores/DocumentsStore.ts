import { defineStore } from 'pinia';
import { Document } from '@/Interfaces/Documents/Documents';
import {
	createDocument,
	createDocumentForHealthCare,
	createDocumentForAnimal,
	createDocumentForShelter,
	getDocument,
	getDocumentsByHealthcare,
	getDocumentsByShelter,
	getDocumentsByAnimal,
	updateDocument,
	deleteDocument,
} from '@/Services/DataLayers/Document.ts';
import { ErrorResponse } from '@/Interfaces/Requests.ts';
import { RouteParamValue } from 'vue-router';

export const useDocumentsStore = defineStore('documents', {
	state: (): {
		documents: Document[];
		document: Document | null;
	} => ({
		documents: [],
		document: null,
	}),
	getters: {
		getCurrentDocument(): Document | null {
			return this.document;
		},
	},
	actions: {
		async getDocument(id: string | RouteParamValue[]): Promise<Document | null> {
			const document: Document | ErrorResponse = await getDocument(id);
			if ('error' in document) {
				return null;
			} else {
				this.document = document;
				return document;
			}
		},
		async getDocumentsByHealthcare(id: number): Promise<Document[]> {
			const documents: Document[] | ErrorResponse =
				await getDocumentsByHealthcare(id);
			if ('error' in documents) {
				return [];
			} else {
				this.documents = documents;
				return documents;
			}
		},
		// async getDocumentsByShelter(id: number): Promise<Document[]> {
		// 	const documents: Document[] | ErrorResponse =
		// 		await getDocumentsByShelter(id);
		// 	if ('error' in documents) {
		// 		return [];
		// 	} else {
		// 		this.documents = documents;
		// 		return documents;
		// 	}
		// },
		async getDocumentsByShelter(id: number): Promise<Document[]> {
			const documents: Document[] | ErrorResponse =
				await getDocumentsByShelter(id);
			if ('error' in documents) {
				return [];
			} else {
				this.documents = documents;
				return documents;
			}
		},
		async getDocumentsByAnimal(id: number): Promise<Document[]> {
			const documents: Document[] | ErrorResponse =
				await getDocumentsByAnimal(id);
			if ('error' in documents) {
				return [];
			} else {
				this.documents = documents;
				return documents;
			}
		},
		async createDocument(document: Document): Promise<Document | null> {
			const newDocument: Document | ErrorResponse =
				await createDocument(document);
			if ('error' in newDocument) {
				return null;
			} else {
				this.documents.push(newDocument);
				return newDocument;
			}
		},
		async createDocumentForHealthCare(
			id: number,
			document: Document,
		): Promise<Document | null> {
			const newDocument: Document | ErrorResponse =
				await createDocumentForHealthCare(id, document);
			if ('error' in newDocument) {
				return null;
			} else {
				this.documents.push(newDocument);
				return newDocument;
			}
		},
		async createDocumentForAnimal(
			id: number,
			document: Document,
		): Promise<Document | null> {
			const newDocument: Document | ErrorResponse =
				await createDocumentForAnimal(id, document);
			if ('error' in newDocument) {
				return null;
			} else {
				this.documents.push(newDocument);
				return newDocument;
			}
		},
		async createDocumentForShelter(
			id: number,
			document: Document,
		): Promise<Document | null> {
			const newDocument: Document | ErrorResponse =
				await createDocumentForShelter(id, document);
			if ('error' in newDocument) {
				return null;
			} else {
				this.documents.push(newDocument);
				return newDocument;
			}
		},
		async updateDocument(
			id: number,
			document: Document
		): Promise<Document | null> {
			const updatedDocument: Document | ErrorResponse =
				await updateDocument(id, document);
			if ('error' in updatedDocument) {
				return null;
			} else {
				this.documents.push(updatedDocument);
				return updatedDocument;
			}
		},
		async deleteDocument(id: string): Promise<boolean> {
			const documentToDelete: Document | ErrorResponse = await deleteDocument(id);
			if ('error' in documentToDelete) {
				return false;
			} else {
				this.documents = this.documents.filter(
					(document: Document) => document.id !== Number(id),
				);
				return true;
			}
		},
	},
});
