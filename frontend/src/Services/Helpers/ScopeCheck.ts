import { Scopes } from '@/Enums/Scopes';

export function hasScope(scopes: string | undefined, requiredScope: Scopes) {
	return scopes?.includes(requiredScope);
}
