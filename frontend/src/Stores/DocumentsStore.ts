import { defineStore } from 'pinia';
import { Document } from '@/Interfaces/Documents/Documents';
import {
	createDocument,
	createDocumentForHealthCare,
	createDocumentForAnimal,
	createDocumentForShelter,
	getDocument,
	getDocumentsByShelter,
	getDocumentsByAnimal,
	updateDocument,
} from '@/Services/DataLayers/Document.ts';
import { ErrorResponse } from '@/Interfaces/Requests.ts';

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
		async getDocument(id: number): Promise<Document | null> {
			const document: Document | ErrorResponse = await getDocument(id);
			if ('error' in document) {
				return null;
			} else {
				this.document = document;
				return document;
			}
		},
		async getDocumentsByShelter(): Promise<Document[]> {
			const documents: Document[] | ErrorResponse =
				await getDocumentsByShelter();
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
			document: Document,
		): Promise<Document | null> {
			const newDocument: Document | ErrorResponse =
				await createDocumentForHealthCare(document);
			if ('error' in newDocument) {
				return null;
			} else {
				this.documents.push(newDocument);
				return newDocument;
			}
		},
		async createDocumentForAnimal(
			document: Document,
		): Promise<Document | null> {
			const newDocument: Document | ErrorResponse =
				await createDocumentForAnimal(document);
			if ('error' in newDocument) {
				return null;
			} else {
				this.documents.push(newDocument);
				return newDocument;
			}
		},
		async createDocumentForShelter(
			document: Document,
		): Promise<Document | null> {
			const newDocument: Document | ErrorResponse =
				await createDocumentForShelter(document);
			if ('error' in newDocument) {
				return null;
			} else {
				this.documents.push(newDocument);
				return newDocument;
			}
		},
		async updateDocument(document: Document): Promise<Document | null> {
			const updatedDocument: Document | ErrorResponse =
				await updateDocument(document);
			if ('error' in updatedDocument) {
				return null;
			} else {
				this.documents.push(updatedDocument);
				return updatedDocument;
			}
		},
	},
});
