﻿using Microsoft.AspNetCore.Mvc;

namespace Salon_System.Controllers
{
    public class CalendarController : Controller
    {
        public IActionResult Index()
        {
            return View();
        }
    }
}
