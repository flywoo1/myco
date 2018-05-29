import { Component, Input, Output, EventEmitter } from '@angular/core';
import { FormGroup, FormControl, Validators, FormBuilder } from '@angular/forms';
import { PersonService } from '../../person.service';
// import { CategoryService } from '../category.service';
import { Observable } from 'rxjs';
import { Person } from '../../person';
// import { Category } from '../category';

@Component({
    selector: 'app-create-person',
    templateUrl: './create-person.component.html',
    styleUrls: ['./create-person.component.css'],
    providers: [PersonService, ] // add a RoleService here if needed
})

// component for creating a person record
export class CreatePersonComponent {

    // our angular form
    create_person_form: FormGroup;

    // @Output will tell the parent component (AppComponent) that an event happened in this component
    @Output() show_read_persons_event = new EventEmitter();
    @Input() coproperty_id;
    @Input() role;

    // TODO list of roles and list of languages
    // categories: Category[];

    // initialize 'person service', 'category service' and 'form builder'
    constructor(
        private personService: PersonService,
        // private categoryService: CategoryService,
        formBuilder: FormBuilder
    ) {
        // based on our html form, build our angular form
        this.create_person_form = formBuilder.group({
            firstName: ['', Validators.required],
            lastName: ['', Validators.required],
            phoneNumber: ['', Validators.required],
            address: ['', Validators.required],
            email: ['', Validators.required]
        });
    }

    // user clicks 'create' button
    createPerson() {

        // send data to server
        this.personService.createPerson(this.create_person_form.value)
            .subscribe(
                 person => {
                    // show an alert to tell the user if person was created or not
                    console.log(person);

                    // go back to list of persons
                    this.readPersons();
                 },
                 error => console.log(error)
             );
    }

    // user clicks the 'read persons' button
    readPersons() {
        this.show_read_persons_event.emit({ title: 'Read ' + this.role, role: this.role, coproperty_id: this.coproperty_id });
    }

    /* TODO what to do when this component were initialized
    OnInit() {
        // read roles and languages from database
        this.categoryService.readCategories()
            .subscribe(categories => this.categories=categories['records']);
    }
    */
}
