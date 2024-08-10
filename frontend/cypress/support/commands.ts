/// <reference types="cypress" />
Cypress.Commands.add('login', (email, password) => {
    cy.visit('/login');
    cy.get('h2').should('have.text', 'Connectez-vous pour accéder à votre compte.');
    cy.get('form').should('exist');
    cy.get('#email').should('exist').type(email);
    cy.get('#password').should('exist').type(password);
    cy.get('button[type="submit"]').should('exist').click();
    cy.get('#association').should('exist')
        .select('Fondation Brigitte Bardot')
        .should('have.value', '1');
    cy.get('#save-changes').should('exist').click();
    cy.url().should('include', '/');
});