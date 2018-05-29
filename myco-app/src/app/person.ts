import { Owner } from './roles/owner';
import { Renter } from './roles/renter';
import { Staff } from './roles/staff';
import { Administrator } from './roles/administrator';

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
        public enabled: boolean,
        // public roles: Role[] se supone que se lee una persona con rol, prop y copro
        public owners: Owner[],
        public renters: Renter[],
        public staffs: Staff[],
        public administrators: Administrator[]
    ) {}
}
