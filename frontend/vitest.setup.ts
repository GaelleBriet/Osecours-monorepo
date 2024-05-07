import createFetchMock from 'vitest-fetch-mock';
import { vi } from 'vitest';

const fetchMock = createFetchMock(vi);
fetchMock.enableMocks();

localStorage.setItem(
	'context',
	JSON.stringify({
		locale: 'fr-FR',
	}),
);

// global.ResizeObserver = vi.fn().mockImplementation(() => ({
// 	observe: vi.fn(),
// 	unobserve: vi.fn(),
// 	disconnect: vi.fn(),
// }));
