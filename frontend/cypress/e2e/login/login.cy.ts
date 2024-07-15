/// <reference types="cypress" />

describe('Authentication tests', () => {
	it('Login successfully', () => {
		cy.fixture('user').then((user) => {
			cy.login(user.email, user.password);
		});
	});
	it('Logout successfully', () => {
		cy.fixture('user').then((user) => {
			cy.login(user.email, user.password);
		});
		cy.get('#user-menu').should('exist').click();
		// Add assertions for successful logout, e.g.,
		// cy.get('button').contains('Déconnexion').click();
		// cy.url().should('include', '/login');
	});
});
