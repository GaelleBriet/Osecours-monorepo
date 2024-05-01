describe('LoginPage test', () => {
	beforeEach(() => {
		cy.visit('/login');
	});
	it('Check if the login page is loaded', () => {
		cy.get('h2').should(
			'have.text',
			'Connectez-vous pour accéder à votre compte.',
		);
	});
	it('Check if login form and inputs are is loaded', () => {
		cy.get('form').should('exist');
		cy.get('#email').should('exist');
		cy.get('#password').should('exist');
	});
	it('Check if submit button is loaded', () => {
		cy.get('button[type="button"]').should('exist');
	});
	it('Fill the form and submit, should redirect to home page', () => {
		cy.fixture('user').then((user) => {
			cy.get('#email').type(user.email);
			cy.get('#password').type(user.password);
		});
		cy.get('button[type="button"]').click();
		cy.get('#association').select('1');
		cy.url().should('include', '/');
	});
});
