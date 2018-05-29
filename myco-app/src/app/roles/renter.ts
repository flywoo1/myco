import {CustomParam} from '../customParam';

export class Renter {
    constructor(
        public idRenter: number,
        public idProperty: number,
        public idCoproperty: number,
        public enabled: boolean,
        public suscriptionDate: Date,
        public customParams: CustomParam[]
    ) {}
}
