/// <reference types="cypress" />
describe('LoginPage test, authenticate successfully', () => {
	beforeEach(() => {
		cy.visit('/login');
	});
	it('Fill the form and submit, should redirect to home page', () => {
		cy.get('h2').should(
			'have.text',
			'Connectez-vous pour accéder à votre compte.',
		);
		cy.get('form').should('exist');

		cy.get('#email').should('exist');
		cy.get('#password').should('exist');
		cy.fixture('user').then((user) => {
			cy.get('#email').type(user.email);
			cy.get('#password').type(user.password);
		});

		cy.get('button[type="submit"]').should('exist').click();

		cy.get('#association').should('exist')
			.select('Fondation Brigitte Bardot')
			.should('have.value', '1');
		cy.url().should('include', '/');
	});
});
