// cypress.d.ts
declare namespace Cypress {
    interface Chainable<Subject = any> {
        /**
         * Custom command to log in to the application.
         * @example
         * cy.login('user@example.com', 'password123')
         */
        login(email: string, password: string): Chainable<any>
    }
}