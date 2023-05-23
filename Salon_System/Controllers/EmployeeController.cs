using Microsoft.AspNetCore.Mvc;
using Salon_System.Data;
using Salon_System.Models;
using System.Text.RegularExpressions;
using System;

namespace Salon_System.Controllers
{
    public class EmployeeController : Controller
    {
        private readonly FeathertouchDbContext _context;

        public EmployeeController(FeathertouchDbContext context)
        {
            this._context = context;
        }

        [HttpGet]
        public IActionResult Index()    //Displays a list of Employees in database
        {
            List<Employee> employeeList = new();
            List<Employee> db = _context.Employee.ToList();

            if (db != null)
            {
                foreach (var emp in db)
                {
                    var employee = new Employee()
                    {
                        Id = emp.Id,
                        FirstName = emp.FirstName,
                        LastName = emp.LastName,
                        JobTitle = emp.JobTitle,
                        JobDesc = emp.JobDesc,
                        HireDate = emp.HireDate
                    };
                    employeeList.Add(employee);
                }
                return View(employeeList);
            }
            return View(employeeList);
        }

//-------------------------------------------------------------------------------------------------------------------------------
//CREATE METHODS

        [HttpGet]
        public IActionResult Create()
        {
            return View();
        }

        [HttpPost]
        public IActionResult Create(Employee emp) //Creates a new Employee in the database
        {
            try
            {
                if (ModelState.IsValid)
                {
                    if (emp.Email != null && EmailIsValid(emp.Email)) //Check if Email is valid
                    {
                        if (emp.Phone != null && PhoneIsValid(emp.Phone) == true) //Check if Phone is valid
                        {
                            var employee = new Employee()
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
                            _context.Employee.Add(employee);                    //Add new Employee to db
                            _context.SaveChanges();                             //Save changes to db
                            TempData["successMessage"] = "Employee Created succesfully"; //Show success message
                            return RedirectToAction("Index");                   //Return to index page
                        }
                        else
                        {
                            TempData["errorMessage"] = "Invalid Mobile number"; //If phone invalid show error message
                            return View();
                        }
                    }
                    else
                    {
                        TempData["errorMessage"] = "Invalid Email"; //If Email invalid show error message
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

//-------------------------------------------------------------------------------------------------------------------------------
//UPDATE METHODS

        [HttpGet]
        public IActionResult Update(int id)
        {
            try
            {
                var emp = _context.Employee.SingleOrDefault(x => x.Id == id);

                if (emp != null)
                {
                    var employeeView = new Employee()
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
                    return View(employeeView);
                }
                else
                {
                    TempData["errorMessage"] = $"Employee details are not available with ID: {id}";
                    return RedirectToAction("Index");
                }
            }
            catch (Exception ex)
            {
                TempData["errorMessage"] = ex.Message;
                return RedirectToAction("Index");
            }
        }

        [HttpPost]
        public IActionResult Update(Employee emp)
        {
            try
            {
                if (ModelState.IsValid)
                {
                    if (emp.Email != null && EmailIsValid(emp.Email)) //Check if Email is valid
                    {
                        if (emp.Phone != null && PhoneIsValid(emp.Phone) == true) //Check if Phone is valid
                        {
                            var employee = new Employee()
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
                            _context.Employee.Update(employee);
                            _context.SaveChanges();
                            TempData["successMessage"] = "Update successful";
                            return RedirectToAction("Index");
                        }
                        else
                        {
                            TempData["errorMessage"] = "Invalid Mobile number"; //If phone invalid show error message
                            return View();
                        }
                    }
                    else
                    {
                        TempData["errorMessage"] = "Invalid Email"; //If Email invalid show error message
                        return View();
                    }
                }
                else
                {
                    TempData["errorMessage"] = "Form invalid";
                    return View();
                }
            }
            catch (Exception ex)
            {
                TempData["errorMessage"] = ex.Message;
                return View();
            }
        }

//-------------------------------------------------------------------------------------------------------------------------------
//VALIDATION METHODS

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
    }
}