import {CustomParam} from '../customParam';

export class Administrator {
    constructor(
        public idAdministrator: number,
        public idCoproperty: number,
        public enabled: boolean,
        public suscriptionDate: Date,
        public customParams: CustomParam[]
    ) {}
}
