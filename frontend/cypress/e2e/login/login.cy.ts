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
		cy.get('#options-menu-item-2').should('exist').click();
		cy.url().should('include', '/login');
	});
	it('Login refused with wrong credentials', () => {
		cy.visit('/login');
		cy.get('h2').should('have.text', 'Connectez-vous pour accéder à votre compte.');
		cy.get('form').should('exist');
		cy.get('#email').should('exist').type('email@test.fr');
		cy.get('#password').should('exist').type('Azerty1*');
		cy.get('button[type="submit"]').should('exist').click();
		cy.get('#alert-component').should('exist').contains('Identifiants incorrects. Veuillez réessayer');
	});
});
