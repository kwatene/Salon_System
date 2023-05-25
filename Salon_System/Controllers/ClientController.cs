using Microsoft.AspNetCore.Mvc;
using Salon_System.Data;
using Salon_System.Models;
using System.Text.RegularExpressions;

namespace Salon_System.Controllers
{
    public class ClientController : Controller
    {
        private readonly FeathertouchDbContext _context; //Database

        public ClientController(FeathertouchDbContext context) //Database Constructor
        {
            this._context = context;
        }

        [HttpGet]
        public IActionResult Index()    //Display list of Clients in the system
        {
            List<Client> clientList = new();
            List<Client> list = _context.Client.ToList();

            if (list != null) //If there are records
            {
                foreach (var c in list) //Read records
                {
                    var client = new Client() //Add records to client object
                    {
                        Id = c.Id,
                        FirstName = c.FirstName,
                        LastName = c.LastName,
                        Gender = c.Gender,
                        DateOfBirth = c.DateOfBirth,
                        Email = c.Email, 
                        Phone = c.Phone,
                        Address = c.Address,
                        Suburb = c.Suburb,
                        City = c.City,
                        Country = c.Country,
                        PostCode = c.PostCode
                    };
                    clientList.Add(client); //Add object to list
                }
                return View(clientList); //Dispay list
            }
            return View(clientList); //No records displayed
        }

        //-------------------------------------------------------------------------------------------------------------------------------
        //VIEW METHODS

        [HttpGet]
        public IActionResult Details(int id) //Display the client/Update view
        {
            try
            {
                var record = _context.Client.SingleOrDefault(x => x.Id == id); //Find client record in database by id

                if (record != null) //if found
                {
                    var client = new Client() //Add details to client object
                    {
                        Id = record.Id,
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
                    return View(client); //Display client details
                }
                else
                {
                    TempData["errorMessage"] = $"Client details are not available with ID: {id}"; //If not found - Display message
                    return RedirectToAction("Index"); //Redirect to Client list
                }
            }
            catch (Exception ex)
            {
                TempData["errorMessage"] = ex.Message;
                return RedirectToAction("Index");
            }
        }

        //-------------------------------------------------------------------------------------------------------------------------------
        //CREATE METHODS

        [HttpGet]
        public IActionResult Create() //Display the Client/Create View
        {
            return View();
        }

        [HttpPost]
        public IActionResult Create(Client input) //Creates and saves a new Client in the system
        {
            try
            {
                if (ModelState.IsValid)
                {
                    if (input.Email != null && EmailIsValid(input.Email)) //Check if email is valid
                    {
                        if (input.Phone != null && PhoneIsValid(input.Phone)) //Check if phone is valid
                        {
                            var newClient = new Client() //If valid, add input to Client record
                            {
                                FirstName = input.FirstName,
                                LastName = input.LastName,
                                Gender = input.Gender,
                                DateOfBirth = input.DateOfBirth,
                                Email = input.Email,
                                Phone = input.Phone,
                                Address = input.Address,
                                Suburb = input.Suburb,
                                City = input.City,
                                Country = input.Country,
                                PostCode = input.PostCode
                            };
                            _context.Client.Add(newClient);                             //Add client record to database
                            _context.SaveChanges();                                         //Save changes made to database
                            TempData["successMessage"] = "Client created successfully";     //Display success message
                            return RedirectToAction("Index");                               //Redirect user to Client list
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
                    TempData["errorMessage"] = "Invalid form"; //If Model invalid show error message (system/code error)
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
        public IActionResult Update(int id) //Display the client/Update view
        {
            try
            {
                var record = _context.Client.SingleOrDefault(x => x.Id == id); //Find client record in database by id

                if (record != null) //if found
                {
                    var client = new Client() //Add details to client object
                    {
                        Id = record.Id,
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
                    return View(client); //Display client details
                }
                else
                {
                    TempData["errorMessage"] = $"Client details are not available with ID: {id}"; //If not found - Display message
                    return RedirectToAction("Index"); //Redirect to Client list
                }
            }
            catch (Exception ex)
            {
                TempData["errorMessage"] = ex.Message;
                return RedirectToAction("Index");
            }
        }

        [HttpPost]
        public IActionResult Update(Client client) //Update client and Save changes in database
        {
            try
            {
                if (ModelState.IsValid) //Check if Model is valid
                {
                    if (client.Email != null && EmailIsValid(client.Email)) //Check if Email is valid
                    {
                        if (client.Phone != null && PhoneIsValid(client.Phone) == true) //Check if Phone is valid
                        {
                            var updateClient = new Client() //Add new input data to client record
                            {
                                Id = client.Id,
                                FirstName = client.FirstName,
                                LastName = client.LastName,
                                Gender = client.Gender,
                                DateOfBirth = client.DateOfBirth,
                                Email = client.Email,
                                Phone = client.Phone,
                                Address = client.Address,
                                Suburb = client.Suburb,
                                City = client.City,
                                Country = client.Country,
                                PostCode = client.PostCode
                            };

                            if (! client.Equals(updateClient))                       //If the record was changed
                            {
                                _context.Client.Update(updateClient);               //Update client record in database
                                _context.SaveChanges();                             //Save changes made to database
                                TempData["successMessage"] = "Update successful";   //Show success message
                                return RedirectToAction("Index");                   //Redirect to client list
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
                        TempData["errorMessage"] = "Invalid form"; //If Model invalid show error message (system/code error)
                        return View();
                    }
                }
                else
                {
                    TempData["errorMessage"] = "Invalid Form"; //If Model invalid show error message (system/code error)
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
//DELETE METHODS

        [HttpGet]
        public IActionResult Delete(int id) //Display the client/Update view
        {
            try
            {
                var record = _context.Client.SingleOrDefault(x => x.Id == id); //Find client record in database by id

                if (record != null) //if found
                {
                    var client = new Client() //Add details to client object
                    {
                        Id = record.Id,
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
                    return View(client); //Display client details
                }
                else
                {
                    TempData["errorMessage"] = $"Client details are not available with ID: {id}"; //If not found - Display message
                    return RedirectToAction("Index"); //Redirect to Client list
                }
            }
            catch (Exception ex)
            {
                TempData["errorMessage"] = ex.Message;
                return RedirectToAction("Index");
            }
        }

        [HttpPost]
        public IActionResult Delete(Client cli)
        {
            try
            {
                var client = _context.Client.SingleOrDefault(x => x.Id == cli.Id); //Find client record in database by id

                if (client != null)
                {
                    _context.Client.Remove(client);
                    _context.SaveChanges();
                    TempData["successMessage"] = "Client Removed";
                    return RedirectToAction("Index");
                }
                else
                {
                    TempData["errorMessage"] = $"Client details not available with Id: {cli.Id}";
                    return RedirectToAction("Index");
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
            string pattern =@"^\d{9,12}$";

            return Regex.IsMatch(phone, pattern); //returns true if phone matches pattern else false
        }
    }
}
