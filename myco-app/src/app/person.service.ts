import { Injectable } from '@angular/core';
import { Http, Response, Headers, RequestOptions } from '@angular/http';
import { Observable } from 'rxjs';
import { map } from 'rxjs/operators';
import { Person } from './person';

@Injectable()

// Service for persons data.
export class PersonService {

    // We need Http to talk to a remote server.
    constructor(private _http: Http) { }

    // Get list of persons from remote server.
    readPersons(): Observable<Person[]> {
        return this._http
            .get('http://localhost/myco/api/person/read.php')
            .pipe(map(res => res.json()));
    }

    // Create person
    createPerson(person): Observable<Person[]> {
        const headers = new Headers({ 'Content-Type': 'application/json' });
        const options = new RequestOptions({ headers: headers });

        return this._http.post(
            'http://localhost/myco/api/person/create.php',
            person,
            options
        ).pipe(map(res => res.json()));
    }

    // Read one person
    readOnePerson(idPerson): Observable<Person[]> {
        return this._http
        .get('http://localhost/myco/api/person/read_one.php?idPerson=' + idPerson)
        .pipe(map(res => res.json()));
    }

    // Update person
    updatePerson(person): Observable<Person[]> {
        const headers = new Headers({ 'Content-Type': 'application/json' });
        const options = new RequestOptions({ headers: headers });

        return this._http.post(
            'http://localhost/myco/api/person/update.php',
            person,
            options
        ).pipe(map(res => res.json()));
    }

    // Delete person
    deletePerson(idPerson): Observable<Person[]> {
        const headers = new Headers({ 'Content-Type': 'application/json' });
        const options = new RequestOptions({ headers: headers });

        return this._http.post(
            'http://localhost/myco/api/person/delete.php',
            { id: idPerson },
            options
        ).pipe(map(res => res.json()));
    }
}
