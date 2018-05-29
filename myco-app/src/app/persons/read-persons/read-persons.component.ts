import { Component, OnInit, Input, Output, EventEmitter, OnChanges } from '@angular/core';
import { PersonService } from '../../person.service';
import { Observable } from 'rxjs';
import { Person } from '../../person';
import { Owner } from '../../roles/owner';

@Component({
    selector: 'app-read-persons',
    templateUrl: './read-persons.component.html',
    styleUrls: ['./read-persons.component.css'],
    providers: [PersonService]
})

export class ReadPersonsComponent implements OnInit, OnChanges {

    /*
      * Needed to notify the 'consumer of this component', which is the 'AppComponent',
        that an 'event' happened in this component.
    */
    @Output() show_create_person_event = new EventEmitter();
    @Output() show_read_one_person_event = new EventEmitter();
    @Output() show_update_person_event = new EventEmitter();
    @Output() show_delete_person_event = new EventEmitter();

    // readpersonbyrolebycopro
    @Input() coproperty_id;
    @Input() role; // owners,administrators, renters, staffs

    // store list of persons
    persons: Person[];

    // initialize personService to retrieve list persons in the ngOnInit()
    constructor(private personService: PersonService) {}

    // methods that we will use later
    createPerson() {
        // tell the parent component (AppComponent)
        this.show_create_person_event.emit({
            title: 'Create ' + this.role,
            role: this.role,
            coproperty_id: this.coproperty_id
        });
    }

    // when user clicks the 'read' button
    readOnePerson(id) {
        console.log('rp comp readOnePerson');
        // tell the parent component (AppComponent)
        this.show_read_one_person_event.emit({
            person_id: id,
            title: 'Read One ' + this.role,
            role: this.role,
            coproperty_id: this.coproperty_id
        });
    }
    // when user clicks the 'update' button
    updatePerson(id) {
        // tell the parent component (AppComponent)
        this.show_update_person_event.emit({
            person_id: id,
            title: 'Update ' + this.role,
            role: this.role,
            coproperty_id: this.coproperty_id
        });
    }
    // when user clicks the 'delete' button
    deletePerson(id) {
        // tell the parent component (AppComponent)
        this.show_delete_person_event.emit({
            person_id: id,
            title: 'Delete ' + this.role,
            role: this.role,
            coproperty_id: this.coproperty_id
        });
    }

    // Read persons from API.
    ngOnInit() {
        this.personService.readRoles(this.coproperty_id, this.role)
            .subscribe(persons =>
                this.persons = persons['records']
        );
    }

    ngOnChanges() {
        this.personService.readRoles(this.coproperty_id, this.role)
            .subscribe(persons =>
                this.persons = persons['records']
        );
    }
}
