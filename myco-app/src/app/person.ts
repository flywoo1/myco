export class Person {
    constructor(
        public idPerson: number,
        public firstName: string,
        public lastName: string,
        public address: string,
        public phoneNumber: number,
        public email: string,
        public password: string,
        public language: string,
        public suscriptionDate: Date,
        public lastUpdate: Date,
        public enabled: boolean
        // TODO roles here
    ) {}
}
