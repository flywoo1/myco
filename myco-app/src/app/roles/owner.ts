import {CustomParam} from '../customParam';

export class Owner {
    constructor(
        public idOwner: number,
        public idProperty: number,
        public idCoproperty: number,
        public enabled: boolean,
        public living: boolean,
        public suscriptionDate: Date,
        public customParams: CustomParam[]
    ) {}
}
