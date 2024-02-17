var tuningParametersEN = [
    {
        category: {
            name: "tires",
            parameters: [
                {
                    name: "tire_pressure",
                    settings: [
                        {
                            name: "front",
                            explanations: "Adjusts the amount of air in the tires.",
                            "more details": "Higher pressure can increase speed but reduce cornering grip."
                        },
                        {
                            name: "rear",
                            explanations: "Adjusts the amount of air in the tires.",
                            "more details": "Higher pressure can increase speed but reduce cornering grip."
                        }
                    ]
                }
            ]
        }
    },
    {
        category: {
            name: "gearing",
            parameters: [
                {
                    name: "gear_ratios",
                    settings: [
                        {
                            name: "forward gears",
                            explanations: "Adjusts the engagement speed of each gear.",
                            "more details": "Shorter ratios improve acceleration but may limit top speed."
                        }
                    ]
                }
            ]
        }
    },
    {
        category: {
            name: "alignment",
            parameters: [
                {
                    name: "camber",
                    settings: [
                        {
                            name: "front",
                            explanations: "The angle of the front wheels relative to the vertical is called front camber. Front camber can be adjusted negatively, meaning the front wheels are tilted inward, or positively, meaning the wheels are tilted outward from the vertical.",
                            "more details": "The consequences of adjusting front camber are as follows:<br>- Negative camber improves cornering grip by allowing the tires to maintain better grip when tilted.<br>- However, excessively negative front camber can reduce straight-line stability and cause uneven wear on the front tires."
                        },
                        {
                            name: "rear",
                            explanations: "The angle of the rear wheels relative to the vertical is called rear camber. Like front camber, rear camber can also be adjusted negatively or positively.",
                            "more details": "The consequences of adjusting rear camber are as follows:<br>- Negative camber can make the car more agile and responsive during turns by allowing the rear wheels to maintain better grip when cornering.<br>- However, excessively negative rear camber can make the car unstable in a straight line and cause uneven wear on the rear tires."
                        }
                    ]
                },
                {
                    name: "toe",
                    settings: [
                        {
                            name: "front",
                            explanations: "The orientation of the front wheels relative to the vertical is called 'toe' in the front. Toe adjustment can be 'toe in,' meaning the front wheels are slightly turned inward, or 'toe out,' meaning the front wheels are slightly turned outward from the vertical.",
                            "more details": "The consequences of adjusting front 'toe' are as follows:<br>- 'Toe in' can improve straight-line stability by keeping the front wheels parallel.<br>- 'Toe out' can increase agility during turns by allowing the front wheels to respond more quickly to changes in direction."
                        },
                        {
                            name: "rear",
                            explanations: "The orientation of the rear wheels relative to the vertical is called rear 'toe.' Rear 'toe' adjustment can also be 'toe in' or 'toe out.'",
                            "more details": "The consequences of adjusting rear 'toe' are as follows:<br>- 'Toe in' can improve straight-line stability by keeping the rear wheels parallel.<br>- 'Toe out' can increase agility during turns by allowing the rear wheels to respond more quickly to changes in direction."
                        }
                    ]
                },
                {
                    name: "front_caster",
                    settings: [
                        {
                            name: "angle",
                            explanations: "The angle of front wheel pivot, adjusted through 'front caster' setting, plays a crucial role in the front suspension geometry of a car.",
                            "more details": "The 'front caster' angle primarily influences straight-line stability and cornering responsiveness of the car.<br>- Positive caster angle, where the top of the front wheels is tilted backward, promotes straight-line stability by helping the wheels return to the center position after a turn or deviation.<br>- Negative caster, where the top of the front wheels is tilted forward, can improve cornering responsiveness by allowing the wheels to turn more easily but may make the car less stable in a straight line.<br>- Adjusting 'front caster' can also impact the driving feel, with positive caster providing a more stable driving sensation and negative caster offering a more agile driving sensation."
                        }
                    ]
                }
            ]
        }
    },
    {
        category: {
            name: "antiroll bars",
            parameters: [
                {
                    name: "antiroll",
                    settings: [
                        {
                            name: "front",
                            explanations: "Adjusting the front antiroll bar controls the stiffness of the car's front suspension. It's designed to reduce body roll when taking corners.",
                            "more details": "The consequences of adjusting the front antiroll bar are as follows:<br>- Stiffer bars reduce body roll, which can improve cornering stability.<br>- However, overly stiff front antiroll bars can reduce driving comfort, especially on uneven roads, by transmitting more irregularities to the suspension and the car's interior."
                        },
                        {
                            name: "rear",
                            explanations: "Adjusting the rear antiroll bar controls the stiffness of the car's rear suspension and also aims to reduce roll.",
                            "more details": "The consequences of adjusting the rear antiroll bar are as follows:<br>- Stiffer rear bars can improve cornering stability by limiting body roll.<br>- However, overly stiff settings can reduce traction of the rear wheels, negatively impacting acceleration and the car's handling when exiting a corner."
                        }
                    ]
                }
            ]
        }
    },
    {
        category: {
            name: "springs",
            parameters: [
                {
                    name: "spring",
                    settings: [
                        {
                            name: "front",
                            explanations: "Adjusting the hardness of the front suspension springs determines how firm or soft the front suspension is.",
                            "more details": "The consequences of adjusting the front spring hardness are as follows:<br>- Stiffer springs improve cornering stability by limiting body roll.<br>- However, excessively stiff front springs can make the ride uncomfortable on uneven terrain by transmitting more irregularities to the suspension and the car's interior."
                        },
                        {
                            name: "rear",
                            explanations: "Adjusting the hardness of the rear suspension springs determines the firmness or softness of the rear suspension.",
                            "more details": "The consequences of adjusting the rear spring hardness are as follows:<br>- Stiffer rear springs improve cornering stability by limiting body roll.<br>- However, excessively stiff rear springs can make the ride uncomfortable on uneven terrain by transmitting more irregularities to the suspension and the car's interior."
                        }
                    ]
                },
                {
                    name: "ride_height",
                    settings: [
                        {
                            name: "front",
                            explanations: "Adjusting the front suspension height changes the distance between the car and the ground.",
                            "more details": "The consequences of adjusting the front suspension height are as follows:<br>- Lower height improves the car's aerodynamics and lowers the center of gravity, which can enhance cornering stability.<br>- However, a lower height reduces ground clearance, making the car vulnerable to obstacles and uneven terrain."
                        },
                        {
                            name: "rear",
                            explanations: "Adjusting the rear suspension height changes the distance between the car and the ground at the rear.",
                            "more details": "The consequences of adjusting the rear suspension height are as follows:<br>- Lower height improves the car's aerodynamics and lowers the center of gravity, which can enhance cornering stability.<br>- However, a lower height reduces ground clearance, making the car vulnerable to obstacles and uneven terrain."
                        }
                    ]
                }
            ]
        }
    },
    {
        category: {
            name: "damping",
            parameters: [
                {
                    name: "rebound_stiffness",
                    settings: [
                        {
                            name: "front",
                            explanations: "Adjusting the stiffness of the front suspension rebound affects the front suspension's ability to absorb shocks as it returns to its normal position after compression. It controls how quickly the front suspension returns to its normal position.",
                            "more details": "The consequences of adjusting front rebound stiffness are as follows:<br>- Higher stiffness provides better control on uneven surfaces and allows the car to track the road better but can make the ride harsher and less comfortable."
                        },
                        {
                            name: "rear",
                            explanations: "Adjusting the stiffness of the rear suspension rebound has a similar effect on the rear suspension's ability to absorb shocks and return to its normal position after compression.",
                            "more details": "The consequences of adjusting rear rebound stiffness are as follows:<br>- Higher stiffness provides better control on uneven surfaces, improves cornering stability, but can make the ride harsher and less comfortable."
                        }
                    ]
                },
                {
                    name: "bump_stiffness",
                    settings: [
                        {
                            name: "front",
                            explanations: "Adjusting the stiffness of the front suspension during bump absorption affects the front suspension's ability to reduce body roll during compression caused by bumps or road irregularities.",
                            "more details": "The consequences of adjusting front bump stiffness are as follows:<br>- Stiffer settings reduce body roll during compression, which can improve cornering stability but may also make the ride harsher and affect comfort."
                        },
                        {
                            name: "rear",
                            explanations: "Adjusting the stiffness of the rear suspension during bump absorption has a similar effect on the rear suspension's ability to reduce body roll during compression caused by bumps or road irregularities.",
                            "more details": "The consequences of adjusting rear bump stiffness are as follows:<br>- Stiffer settings reduce body roll during compression, which can improve cornering stability but may also make the ride harsher and affect comfort."
                        }
                    ]
                }
            ]
        }
    },
    {
        category: {
            name: "aero",
            parameters: [
                {
                    name: "downforce",
                    settings: [
                        {
                            name: "front",
                            explanations: "Adjusts the aerodynamic downforce at the front.",
                            "more details": "Greater downforce improves traction but can reduce top speed."
                        },
                        {
                            name: "rear",
                            explanations: "Adjusts the aerodynamic downforce at the rear.",
                            "more details": "Greater downforce improves traction but can reduce top speed."
                        }
                    ]
                }
            ]
        }
    },
    {
        category: {
            name: "brake",
            parameters: [
                {
                    name: "braking_force",
                    settings: [
                        {
                            name: "balance",
                            explanations: "Adjusts the distribution of braking force between the front and rear.",
                            "more details": "Front-oriented balance provides better control, while rear-oriented balance can assist in turning during braking."
                        },
                        {
                            name: "pressure",
                            explanations: "Adjusts the overall intensity of the braking force.",
                            "more details": "Higher pressure increases brake responsiveness but may lead to easier wheel lock."
                        }
                    ]
                }
            ]
        }
    },
    {
        category: {
            name: "differential",
            parameters: [
                {
                    name: "front",
                    settings: [
                        {
                            name: "acceleration",
                            explanations: "Adjusts the degree of locking of the front differential during acceleration.",
                            "more details": "A higher level increases traction but may make the car less agile."
                        },
                        {
                            name: "deceleration",
                            explanations: "Adjusts the degree of locking of the front differential during deceleration.",
                            "more details": "A higher level improves control during braking but may cause understeer."
                        }
                    ]
                },
                {
                    name: "rear",
                    settings: [
                        {
                            name: "acceleration",
                            explanations: "Adjusts the degree of locking of the rear differential during acceleration.",
                            "more details": "A higher level increases traction but may make the car less agile."
                        },
                        {
                            name: "deceleration",
                            explanations: "Adjusts the degree of locking of the rear differential during deceleration.",
                            "more details": "A higher level improves control during braking but may cause understeer."
                        }
                    ]
                },
                {
                    name: "balance",
                    settings: [
                        {
                            name: "angle",
                            explanations: "Adjusts the distribution of force between the front and rear differentials.",
                            "more details": "A setting favoring the front can improve traction and handling in corners, while a rear-biased setting can improve straight-line acceleration."
                        }
                    ]
                }
            ]
        }
    },
    {
        category: {
            name: "engine",
            parameters: [
                {
                    name: "air/fuel ratio",
                    settings: [
                        {
                            name: "adjustment",
                            explanations: "Modifies the air/fuel ratio in the engine.",
                            "more details": "A richer mixture can increase power but may reduce efficiency and increase emissions."
                        }
                    ]
                },
                {
                    name: "ignition timing",
                    settings: [
                        {
                            name: "adjustment",
                            explanations: "Adjusts the timing of the spark ignition in the cylinders.",
                            "more details": "Advancing ignition timing can increase power and efficiency but may risk engine knocking."
                        }
                    ]
                }
            ]
        }
    },
    {
        category: {
            name: "exhaust",
            parameters: [
                {
                    name: "back pressure",
                    settings: [
                        {
                            name: "adjustment",
                            explanations: "Controls the pressure within the exhaust system.",
                            "more details": "Reducing back pressure can increase performance but may reduce low-end torque."
                        }
                    ]
                }
            ]
        }
    },
    {
        category: {
            name: "intake",
            parameters: [
                {
                    name: "airflow",
                    settings: [
                        {
                            name: "adjustment",
                            explanations: "Manages the airflow entering the engine.",
                            "more details": "Increased airflow improves engine response and power, but may require adjustments to engine management."
                        }
                    ]
                }
            ]
        }
    }
];


