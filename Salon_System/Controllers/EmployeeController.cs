using Microsoft.AspNetCore.Mvc;
using Salon_System.Data;
using Salon_System.Models;
using System.Text.RegularExpressions;
using System;
using Microsoft.EntityFrameworkCore;

namespace Salon_System.Controllers
{
    public class EmployeeController : Controller
    {
        private readonly FeathertouchDbContext _context; //Global Variable to Connect to Database

        public EmployeeController(FeathertouchDbContext context) //Database Constructor
        {
            this._context = context;
        }

        //---------------------------------------------------------------------------------------------------------------
        //VIEW ALL CLIENTS
        //---------------------------------------------------------------------------------------------------------------

        [HttpGet]
        public IActionResult Index()    //Display list of Employees in the system
        {
            List<Employee> employeeList = new();
            List<Employee> db = _context.Employee.ToList(); //Add all records from database to list

            if (db != null) //If there are records
            {
                foreach (var emp in db) //Read records
                {
                    var employee = new Employee() //Add records to Employee objects
                    {
                        Id = emp.Id,
                        FirstName = emp.FirstName,
                        LastName = emp.LastName,
                        JobTitle = emp.JobTitle,
                        JobDesc = emp.JobDesc,
                        HireDate = emp.HireDate
                    };
                    employeeList.Add(employee); //Add object to list
                }
                return View(employeeList); //Dispay list
            }
            return View(employeeList); //Else no records displayed
        }

        //---------------------------------------------------------------------------------------------------------------
        //VIEW SELECTED EMPLOYEE
        //---------------------------------------------------------------------------------------------------------------

        [HttpGet]
        public IActionResult Details(int id) //Display the selected clients details
        {
            try
            {
                var record = _context.Employee.SingleOrDefault(x => x.Id == id); //Find Employee record in database by id

                if (record != null) //if found
                {
                    var employee = new Employee() //Add details to Employee object
                    {
                        Id = record.Id,
                        JobTitle = record.JobTitle,
                        JobDesc = record.JobDesc,
                        HireDate = record.HireDate,
                        FirstName = record.FirstName,
                        LastName = record.LastName,
                        Gender = record.Gender,
                        DateOfBirth = record.DateOfBirth,
                        Email = record.Email,
                        Phone = record.Phone,
                        Address = record.Address,
                        Suburb = record.Suburb,
                        City = record.City,
                        Country = record.Country,
                        PostCode = record.PostCode
                    };
                    return View(employee); //Display Employee details
                }
                else
                {
                    TempData["errorMessage"] = $"Employee details are not available with ID: {id}"; //If not found - Display message
                    return RedirectToAction("Index"); //Redirect to Employee list
                }
            }
            catch (Exception ex)
            {
                TempData["errorMessage"] = ex.Message;
                return RedirectToAction("Index");
            }
        }

        //---------------------------------------------------------------------------------------------------------------
        //CREATE METHODS
        //---------------------------------------------------------------------------------------------------------------

        [HttpGet]
        public IActionResult Create() //Display the Client/Create View
        {
            return View();
        }

        [HttpPost]
        public IActionResult Create(Employee emp) //Creates and saves a new Client in the system
        {
            try
            {
                if (ModelState.IsValid)
                {
                    if (emp.Email != null && EmailIsValid(emp.Email)) //Check if Email is valid
                    {
                        if (emp.Phone != null && PhoneIsValid(emp.Phone) == true) //Check if Phone is valid
                        {
                            var newEmployee = new Employee() //If valid, add input to Employee object
                            {
                                JobTitle = emp.JobTitle,
                                JobDesc = emp.JobDesc,
                                HireDate = emp.HireDate,
                                FirstName = emp.FirstName,
                                LastName = emp.LastName,
                                Gender = emp.Gender,
                                DateOfBirth = emp.DateOfBirth,
                                Email = emp.Email,
                                Phone = emp.Phone,
                                Address = emp.Address,
                                Suburb = emp.Suburb,
                                City = emp.City,
                                Country = emp.Country,
                                PostCode = emp.PostCode,
                            };
                            _context.Employee.Add(newEmployee);                         //Add employee record to database
                            _context.SaveChanges();                                     //Save changes made to database
                            TempData["successMessage"] = "New Employee Added";          //Display success message
                            return RedirectToAction("Index");                           //Redirect user to Employee list
                        }
                        else
                        {
                            ModelState.AddModelError("Phone", "Invalid Phone Number");//If phone invalid show error message
                            return View();
                        }
                    }
                    else
                    {
                        ModelState.AddModelError("Email", "Invalid Email"); //If Email invalid show error message
                        return View();
                    }
                }
                else
                {
                    TempData["errorMessage"] = "Form invalid"; //If form invalid show error message
                    return View();
                }
            }
            catch (Exception ex)
            {
                TempData["errorMessage"] = ex.Message;
                return View();
            }
        }

        //---------------------------------------------------------------------------------------------------------------
        //UPDATE METHODS
        //---------------------------------------------------------------------------------------------------------------

        [HttpGet]
        public IActionResult Update(int id) //Display the Employee/Update view
        {
            try
            {
                var emp = _context.Employee.SingleOrDefault(x => x.Id == id); //Find client record in database by id

                if (emp != null) //If client record found
                {
                    var employee = new Employee() //Add details to client object
                    {
                        Id = emp.Id,
                        FirstName = emp.FirstName,
                        LastName = emp.LastName,
                        Gender = emp.Gender,
                        DateOfBirth = emp.DateOfBirth,
                        Email = emp.Email,
                        Phone = emp.Phone,
                        Address = emp.Address,
                        Suburb = emp.Suburb,
                        City = emp.City,
                        Country = emp.Country,
                        PostCode = emp.PostCode,
                        JobTitle = emp.JobTitle,
                        JobDesc = emp.JobDesc,
                        HireDate = emp.HireDate
                    };
                    return View(employee); //Display client details
                }
                else
                {                                                           //If not found - Display error message
                    TempData["errorMessage"] = $"Employee details are not available with ID: {id}";
                    return RedirectToAction("Index");                       //Redirect to Client list
                }
            }
            catch (Exception ex)
            {
                TempData["errorMessage"] = ex.Message;
                return RedirectToAction("Index");
            }
        }

        [HttpPost]
        public IActionResult Update(Employee emp) //Update Employee and Save changes in database
        {
            try
            {
                if (ModelState.IsValid) //Check if Model is valid
                {
                    if (emp.Email != null && EmailIsValid(emp.Email)) //Check if Email is valid
                    {
                        if (emp.Phone != null && PhoneIsValid(emp.Phone) == true) //Check if Phone is valid
                        {
                            Employee? e = _context.Employee.AsNoTracking().FirstOrDefault(x => x.Id == emp.Id);
                            //get the client from the database for comparison

                            if (emp != null && e != null && EmployeeIsTheSame(emp, e) == false) 
                            //If input data is not the same as original
                            {
                                var updateEmp = new Employee() //Add input data to new employee object
                                {
                                    Id = emp.Id,
                                    FirstName = emp.FirstName,
                                    LastName = emp.LastName,
                                    Gender = emp.Gender,
                                    DateOfBirth = emp.DateOfBirth,
                                    Email = emp.Email,
                                    Phone = emp.Phone,
                                    Address = emp.Address,
                                    Suburb = emp.Suburb,
                                    City = emp.City,
                                    Country = emp.Country,
                                    PostCode = emp.PostCode,
                                    JobTitle = emp.JobTitle,
                                    JobDesc = emp.JobDesc,
                                    HireDate = emp.HireDate
                                };
                                _context.Employee.Update(updateEmp);                //Update employee record
                                _context.SaveChanges();                             //Save changes made to database
                                TempData["successMessage"] = "Employee Updated";    //Show success message
                                return RedirectToAction("Details", new { id = emp?.Id });
                                                                                    //Redirect to Client/Details
                            }
                            else
                            {                                                       //Else employee is the same
                                TempData["sameStateMessage"] = "No changes made";   //Show same state message
                                return RedirectToAction("Details", new { id = emp?.Id });
                                                                                    //Redirect to Client/Details
                            }
                        }
                        else
                        {
                            ModelState.AddModelError("Phone", "Invalid Phone Number");//If phone invalid show error
                            return View();
                        }
                    }
                    else
                    {
                        ModelState.AddModelError("Email", "Invalid Email"); //If Email invalid show error
                        return View();
                    }
                }
                else
                {
                    TempData["errorMessage"] = "Invald Form"; //If Model invalid show error alert
                    return View();
                }
            }
            catch (Exception ex)
            {
                TempData["errorMessage"] = ex.Message; //If other problems show error alert
                return View();
            }
        }

        //---------------------------------------------------------------------------------------------------------------
        //DELETE METHOD (Delete operations are coded in the Details View)
        //---------------------------------------------------------------------------------------------------------------

        [HttpPost]
        public IActionResult Details(Employee emp)
        {
            try
            {
                var employee = _context.Employee.SingleOrDefault(x => x.Id == emp.Id); //Find employee in database by id

                if (employee != null)                                   //If record exists
                {
                    _context.Employee.Remove(employee);  //Remove employee from database //Note: Add to Archive instead
                    _context.SaveChanges();                             //Save changes
                    TempData["successMessage"] = $"Employee removed";    //Show success message
                    return RedirectToAction("Index");                   //Return to Employee/Index
                }
                else
                {
                    //If record doesn't exist, show error message
                    TempData["errorMessage"] = $"Employee details not available with Id: {emp.Id}";
                    return RedirectToAction("Index");
                }
            }
            catch (Exception ex)
            {
                TempData["errorMessage"] = ex.Message;
                return View();
            }
        }

        //---------------------------------------------------------------------------------------------------------------
        //VALIDATION METHODS
        //---------------------------------------------------------------------------------------------------------------

        public bool EmailIsValid(string email) //Checks if email is valid using Regular Expression
        {
            //Check the email has 1 @ symbol followed by a fullstop with at least 1 character before and after each symbol. No whitespace and specified domains allowed.
            string pattern = @"^[^@\s]+@[^@\s]+\.(com|co.nz|ac.nz|org.nz|govt.nz|co.au|co.uk|net)$";

            return Regex.IsMatch(email, pattern); //returns true if email matches pattern else false
        }

        public bool PhoneIsValid(string phone)  //Checks if phone is valid using Regular Expression
        {
            //Check the input contains between 9-12 digits only
            string pattern = @"^\d{9,12}$";

            return Regex.IsMatch(phone, pattern); //returns true if phone matches pattern else false
        }

        public bool EmployeeIsTheSame(Employee emp, Employee e)
        {
            if (e?.FirstName == emp?.FirstName && e?.LastName == emp?.LastName && e?.Gender == emp?.Gender
            && e?.DateOfBirth == emp?.DateOfBirth && e?.Email == emp?.Email
            && e?.Phone == emp?.Phone && e?.Address == emp?.Address && e?.Suburb == emp?.Suburb
            && e?.City == emp?.City && e?.Country == emp?.Country && e?.PostCode == emp?.PostCode && e?.JobTitle == emp?.JobTitle && emp?.JobDesc == e?.JobDesc && emp?.HireDate == e?.HireDate)
            {
                return true;
            }
            return false;
        }
    }
}