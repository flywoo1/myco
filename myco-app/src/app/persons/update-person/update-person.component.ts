import { Component, OnChanges, Input, Output, EventEmitter } from '@angular/core';
import { FormGroup, FormControl, Validators, FormBuilder } from '@angular/forms';
import { PersonService } from '../../person.service';
// import { CategoryService } from '../category.service';
import { Observable } from 'rxjs';
// import { Category } from '../category';

@Component({
  selector: 'app-update-person',
  templateUrl: './update-person.component.html',
  styleUrls: ['./update-person.component.css'],
  providers: [PersonService] // , CategoryService
})
export class UpdatePersonComponent implements OnChanges {

  // our angular form
  update_person_form: FormGroup;

  @Output() show_read_persons_event = new EventEmitter();
  @Input() person_id;
  @Input() coproperty_id;
  @Input() role;

  // categories: Category[];

  // initialize person & category services
  constructor(
    private personService: PersonService,
    // private categoryService: CategoryService,
    private formBuilder: FormBuilder
  ) {

    // build angular form
    this.update_person_form = this.formBuilder.group({
      firstName: ['', Validators.required],
      lastName: ['', Validators.required],
      phoneNumber: ['', Validators.required],
      address: ['', Validators.required],
      email: ['', Validators.required],
      password: ['', Validators.required],
      language: ['', Validators.required],
      enabled: ['']
    });
  }

  // user clicks 'update' button
  updatePerson() {

    // add person_id in the object so it can be updated
    this.update_person_form.value.id = this.person_id;
    this.update_person_form.value.coproperty_id = this.coproperty_id;
    this.update_person_form.value.role = this.role;

    // send data to server
    this.personService.updatePerson(this.update_person_form.value)
      .subscribe(
      person => {
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

  // call the record when 'person_id' was changed
  ngOnChanges() {

    // read one person record
    this.personService.readOnePerson(this.person_id)
      .subscribe(person => {

        // put values in the form
        this.update_person_form.patchValue({
          firstName: person.firstName,
          lastName: person.lastName,
          address: person.address,
          phoneNumber: person.phoneNumber,
          email: person.email,
          password: person.password,
          language: person.language,
          enabled: person.enabled
        });
      });
  }

  // read categories from database
  /*
  ngOnInit() {
    this.categoryService.readCategories()
      .subscribe(categories => this.categories = categories['records']);
  }
  */
}
