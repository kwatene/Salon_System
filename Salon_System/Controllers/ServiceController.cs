using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.ViewComponents;
using Microsoft.EntityFrameworkCore;
using Salon_System.Controllers.ViewModels;
using Salon_System.Data;
using Salon_System.Models;
using System.Linq.Expressions;

namespace Salon_System.Controllers
{
    public class ServiceController : Controller
    {
        private readonly FeathertouchDbContext db;

        public ServiceController(FeathertouchDbContext context)
        {
            this.db = context;
        }

        //---------------------------------------------------------------------------------------------------------------
        //VIEW ALL SERVICES
        //---------------------------------------------------------------------------------------------------------------

        [HttpGet]
        public IActionResult Index()                 //View list of Services
        {
            List<Service> serviceList = new();
            var list = db.Service.ToList();          //Get records from Service Table in db

            if (list != null)                        //If records exist
            {
                foreach (var service in list)        //Read each record in list
                {

                    var Service = new Service()
                    {
                        Id = service.Id,
                        Name = service.Name,
                        Description = service.Description,
                        DurationHours = service.DurationHours,
                        DurationMins = service.DurationMins,
                        Charge = service.Charge,
                        CategoryName = GetCategoryName(service.CategoryId),
                        EmployeeNames = GetCapableStaff(service.Id)
                    };

                    serviceList.Add(Service);
                }
                return View(serviceList);            //Display serviceList in view
            }
            return View(serviceList);
        }

        //---------------------------------------------------------------------------------------------------------------
        //VIEW SELECTED SERVICE
        //---------------------------------------------------------------------------------------------------------------

        [HttpGet]
        public IActionResult Details(int id)                              //Display the selected clients details
        {
            try
            {
                var service = db.Service.SingleOrDefault(x => x.Id == id); //Find client in db

                if (service != null)                                       //if found
                {
                    var Service = new Service()                           //Get client details
                    {
                        Id = service.Id,
                        Name = service.Name,
                        Description = service.Description,
                        DurationHours = service.DurationHours,
                        DurationMins = service.DurationMins,
                        Charge = service.Charge,
                        CategoryName = GetCategoryName(service.CategoryId)
                    };
                    return View(Service);                                 //Display client details
                }
                else
                {
                    TempData["errorMessage"] = $"Service details are not available with ID: {id}"; //If not found - Display message
                    return RedirectToAction("Index");                     //Redirect to Client list
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
        [AutoValidateAntiforgeryToken]
        public IActionResult Create()                                   //Display the Service/Create View/Form
        {
            DisplayAllCategories();
            DisplayAllEmployees();

            return View();
        }

        [HttpPost]
        public IActionResult Create(Service service)   //Retrieve form details to create and save a new Service in the system
        {
            try
            {
                if (ModelState.IsValid)
                {
                    var Service = new Service()                          //Add service record to database
                    {
                        Name = service.Name,
                        Description = service.Description,
                        DurationHours = service.DurationHours,
                        DurationMins = service.DurationMins,
                        Charge = service.Charge,
                        CategoryId = service.CategoryId
                    };
                    db.Service.Add(Service);
                    db.SaveChanges();                                     //Save changes made to Service Table

                    if (service.EmployeeIds != null)
                    {
                        var temp = db.Service.Where(s => s.Name == service.Name).SingleOrDefault();  //Get Service Id
                        
                        if((temp != null) && (service.Name != null) && (service.Name.Equals(temp.Name)))                                                     
                        {
                            foreach (var employeeId in service.EmployeeIds)                    //Loop through employee Ids
                            {
                                var serviceEmployee = new ServiceEmployee()                    //associate each employee with service
                                {
                                    ServiceId = temp.Id,
                                    EmployeeId = employeeId
                                };
                                db.ServiceEmployee.Add(serviceEmployee);
                                db.SaveChanges();
                            }

                            TempData["successMessage"] = "Added new Service: " + service.Name;      //Display success message
                        }
                        else
                        {
                            TempData["successMessage"] = "Added new Service: " + service.Name + "serviceId not found";      //Display message with no Employees
                        }
                    }
                    else
                    {
                        TempData["successMessage"] = "Added new Service: " + service.Name + "No employees";      //Display message with no Employees
                    }

                    return RedirectToAction("Index");                                       //Redirect user to Service list
                }
                else
                {

                    DisplayAllCategories(); 
                    DisplayAllEmployees();
                    TempData["errorMessage"] = "Invalid form";                              //If form invalid show error message
                    return View(service);
                }
            }
            catch (Exception ex)
            {
                DisplayAllCategories();
                DisplayAllEmployees();
                TempData["errorMessage"] = ex.Message;
                return View();
            }
        }

        //---------------------------------------------------------------------------------------------------------------
        //UPDATE METHODS
        //---------------------------------------------------------------------------------------------------------------

        public IActionResult Update()
        {
            return View();
        }

        //Delete a Service
        public IActionResult Delete()
        {
            return View();
        }

        //---------------------------------------------------------------------------------------------------------------
        //GET METHODS
        //---------------------------------------------------------------------------------------------------------------

        public string GetCategoryName(int? id)      //Get name of category to display
        {
            //Query db to get category name
            var catName = db.ServiceCategory.Where(c => c.Id == id).Select(c => c.Name).SingleOrDefault();

            if (catName != null)                    //if found
            {
                return catName;                     //return category name
            }
            return "Not found";                     //Else not found
        }

        public List<String>? GetCapableStaff(int? id)         //Get names of Employees associated with the service to display
        {
            //Query db to get all records associated to ServiceId
            var serviceEmployee = db.ServiceEmployee.Where(se => se.ServiceId == id).ToList();
            List<String> employees = new();                   //List to return employees names only

            if (serviceEmployee != null)                       //If records exist
            {
                foreach (var s in serviceEmployee)            //Read each record
                {                                             //Query db to get the Employee by Id
                    var emp = db.Employee.Where(e => e.Id == s.EmployeeId).FirstOrDefault();

                    if (emp != null)                          //If found
                    {                                         //Add name to list
                        employees.Add(emp.FirstName + " " + emp.LastName + "   ");
                    }
                }
                return employees;                             //return list
            }
            else
            {
                employees.Add("No Employees");                //Else no employees
            }

            return employees;                                 //Return list
        }

        public void DisplayAllCategories()                     //Display the Categories for user to select
        {
            List<ServiceCategory> categoryList = new();
            var category = db.ServiceCategory.ToList();

            if (category != null)                                     
            {
                foreach (var c in category)
                {
                    var Category = new ServiceCategory()
                    {
                        Id = c.Id,
                        Name = c.Name
                    };
                    categoryList.Add(Category);
                }
                ViewBag.Categories = categoryList;
            }
            else { ViewBag.Categories = "No Categories"; }
        }

        public void DisplayAllEmployees()                     //Display all Employees for user to select
        {
            List<Employee> employeeList = new();
            var employees = db.Employee.ToList();

            if (employees != null) //Select Capable staff for Service
            {
                foreach (var e in employees)
                {
                    var Employee = new Employee()
                    {
                        Id = e.Id,
                        FirstName = e.FirstName,
                        LastName = e.LastName
                    };
                    employeeList.Add(Employee);
                }
                ViewBag.Employees = employeeList;
            }
            else { ViewBag.Employees = "No Employees"; }
        }
    }
}
