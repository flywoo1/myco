import { Owner } from './roles/owner';
import { Renter } from './roles/renter';
import { Administrator } from './roles/administrator';
import { Staff } from './roles/staff';

export class Role {
    constructor(
        public Owners: Owner[],
        public Renters: Renter[],
        public Administrators: Administrator[],
        public Staffs: Staff[],
    ) {}
}
