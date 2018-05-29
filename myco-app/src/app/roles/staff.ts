import {CustomParam} from '../customParam';

export class Staff {
    constructor(
        public idStaff: number,
        public idCoproperty: number,
        public enabled: boolean,
        public living: boolean,
        public suscriptionDate: Date,
        public customParams: CustomParam[]
    ) {}
}
