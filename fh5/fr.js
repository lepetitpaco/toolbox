var tuningParametersFR = [
    {
        category: {
            name: "tires",
            parameters: [
                {
                    name: "tire_pressure",
                    settings: [
                        {
                            name: "front",
                            explanations: "Modifie la quantité d'air dans les pneus.",
                            "more details": "Une pression plus élevée peut augmenter la vitesse mais réduire la prise en virage."
                        },
                        {
                            name: "rear",
                            explanations: "Modifie la quantité d'air dans les pneus.",
                            "more details": "Une pression plus élevée peut augmenter la vitesse mais réduire la prise en virage."
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
                            explanations: "Ajuste la vitesse d'engagement de chaque vitesse.",
                            "more details": "Des rapports courts améliorent l'accélération mais peuvent limiter la vitesse maximale."
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
                            explanations: "L'angle des roues avant par rapport à la verticale est appelé camber avant. Le camber avant peut être réglé négativement, ce qui signifie que les roues avant sont inclinées vers l'intérieur, ou positivement, ce qui signifie que les roues sont inclinées vers l'extérieur par rapport à la verticale.",
                            "more details": "Les conséquences du réglage du camber avant sont les suivantes :<br>- Un carrossage négatif améliore l'adhérence en virage en permettant aux pneus de maintenir une meilleure adhérence lorsqu'ils sont inclinés.<br>- Cependant, un camber avant excessivement négatif peut réduire la stabilité en ligne droite et provoquer une usure inégale des pneus avant."
                        },
                        {
                            name: "rear",
                            explanations: "L'angle des roues arrière par rapport à la verticale est appelé camber arrière. Comme pour le camber avant, le camber arrière peut également être réglé négativement ou positivement.",
                            "more details": "Les conséquences du réglage du camber arrière sont les suivantes :<br>- Un carrossage négatif peut rendre la voiture plus agile et plus réactive lors des virages en permettant aux roues arrière de maintenir une meilleure adhérence en virage.<br>- Cependant, un camber arrière excessivement négatif peut rendre la voiture plus instable en ligne droite et provoquer une usure inégale des pneus arrière."
                        }
                    ]
                },
                {
                    name: "toe",
                    settings: [
                        {
                            name: "front",
                            explanations: "L'orientation des roues avant par rapport à la verticale est appelée 'toe' avant. Le réglage du 'toe' avant peut être en 'toe in', ce qui signifie que les roues avant sont légèrement tournées vers l'intérieur, ou en 'toe out', ce qui signifie que les roues avant sont légèrement tournées vers l'extérieur par rapport à la verticale.",
                            "more details": "Les conséquences du réglage du 'toe' avant sont les suivantes :<br>- Le 'toe in' peut améliorer la stabilité en ligne droite en maintenant les roues parallèles.<br>- Le 'toe out' peut augmenter l'agilité en virage en permettant aux roues avant de réagir plus rapidement aux changements de direction."
                        },
                        {
                            name: "rear",
                            explanations: "L'orientation des roues arrière par rapport à la verticale est appelée 'toe' arrière. Le réglage du 'toe' arrière peut également être en 'toe in' ou en 'toe out'.",
                            "more details": "Les conséquences du réglage du 'toe' arrière sont les suivantes :<br>- Le 'toe in' peut améliorer la stabilité en ligne droite en maintenant les roues arrière parallèles.<br>- Le 'toe out' peut augmenter l'agilité en virage en permettant aux roues arrière de réagir plus rapidement aux changements de direction."
                        }
                    ]
                },
                {
                    name: "front_caster",
                    settings: [
                        {
                            name: "angle",
                            explanations: "L'angle de pivotement des roues avant, ajusté grâce au réglage du 'front caster', joue un rôle essentiel dans la géométrie de la suspension avant d'une voiture.",
                            "more details": "L'angle du 'front caster' influence principalement la stabilité en ligne droite et la réactivité en virage de la voiture.<br>- Un angle de 'caster' positif, où le haut des roues avant est incliné vers l'arrière, favorise la stabilité en ligne droite en aidant les roues à revenir à la position centrale après un virage ou une déviation.<br>- Un 'caster' négatif, où le haut des roues avant est incliné vers l'avant, peut améliorer la réactivité en virage en permettant aux roues de tourner plus facilement, mais il peut rendre la voiture moins stable en ligne droite.<br>- Le réglage du 'front caster' peut également avoir un impact sur la sensation de conduite, avec un 'caster' positif offrant une sensation de conduite plus stable et un 'caster' négatif offrant une sensation de conduite plus agile."
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
                            explanations: "Le réglage de l'antiroll bar avant contrôle la rigidité de la suspension avant de la voiture. Il est conçu pour réduire le roulis de la carrosserie lors de la prise de virages.",
                            "more details": "Les conséquences du réglage de l'antiroll bar avant sont les suivantes :<br>- Des barres plus rigides réduisent le roulis de la carrosserie, ce qui peut améliorer la stabilité en virage.<br>- Cependant, des barres antiroll avant trop rigides peuvent réduire le confort de conduite, notamment sur des routes inégales, en transmettant plus d'irrégularités à la suspension et à l'habitacle de la voiture."
                        },
                        {
                            name: "rear",
                            explanations: "Le réglage de l'antiroll bar arrière contrôle la rigidité de la suspension arrière de la voiture et vise également à réduire le roulis.",
                            "more details": "Les conséquences du réglage de l'antiroll bar arrière sont les suivantes :<br>- Des barres plus rigides à l'arrière peuvent améliorer la stabilité en virage, en limitant le roulis de la carrosserie.<br>- Cependant, un réglage trop rigide peut réduire la traction des roues arrière, ce qui peut affecter négativement l'accélération et la maniabilité de la voiture en sortie de virage."
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
                            explanations: "Le réglage de la dureté des ressorts de suspension avant détermine à quel point la suspension avant est ferme ou souple.",
                            "more details": "Les conséquences du réglage de la dureté des ressorts avant sont les suivantes :<br>- Des ressorts plus rigides améliorent la stabilité en virage en limitant le roulis de la carrosserie.<br>- Cependant, des ressorts avant trop rigides peuvent rendre la conduite inconfortable sur des terrains inégaux en transmettant davantage d'irrégularités à la suspension et à l'habitacle de la voiture."
                        },
                        {
                            name: "rear",
                            explanations: "Le réglage de la dureté des ressorts de suspension arrière détermine la fermeté ou la souplesse de la suspension arrière.",
                            "more details": "Les conséquences du réglage de la dureté des ressorts arrière sont les suivantes :<br>- Des ressorts arrière plus rigides améliorent la stabilité en virage en limitant le roulis de la carrosserie.<br>- Cependant, des ressorts arrière trop rigides peuvent rendre la conduite inconfortable sur des terrains inégaux en transmettant davantage d'irrégularités à la suspension et à l'habitacle de la voiture."
                        }
                    ]
                },
                {
                    name: "ride_height",
                    settings: [
                        {
                            name: "front",
                            explanations: "Le réglage de la hauteur de la suspension avant ajuste la distance entre la voiture et le sol.",
                            "more details": "Les conséquences du réglage de la hauteur de suspension avant sont les suivantes :<br>- Une hauteur plus basse améliore l'aérodynamisme de la voiture et abaisse le centre de gravité, ce qui peut améliorer la stabilité en virage.<br>- Cependant, une hauteur plus basse réduit la garde au sol, ce qui peut rendre la voiture vulnérable aux obstacles et aux terrains inégaux."
                        },
                        {
                            name: "rear",
                            explanations: "Le réglage de la hauteur de la suspension arrière ajuste la distance entre la voiture et le sol à l'arrière.",
                            "more details": "Les conséquences du réglage de la hauteur de suspension arrière sont les suivantes :<br>- Une hauteur plus basse améliore l'aérodynamisme de la voiture et abaisse le centre de gravité, ce qui peut améliorer la stabilité en virage.<br>- Cependant, une hauteur plus basse réduit la garde au sol, ce qui peut rendre la voiture vulnérable aux obstacles et aux terrains inégaux."
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
                            explanations: "Le réglage de la rigidité du rebondissement de la suspension avant affecte la capacité de la suspension avant à absorber les chocs lorsqu'elle se rétablit après une compression. Il contrôle la vitesse à laquelle la suspension avant revient à sa position normale.",
                            "more details": "Les conséquences du réglage de la rigidité du rebondissement avant sont les suivantes :<br>- Une rigidité plus élevée offre un meilleur contrôle sur les surfaces inégales et permet à la voiture de mieux suivre la route, mais peut rendre la conduite plus dure et moins confortable."
                        },
                        {
                            name: "rear",
                            explanations: "Le réglage de la rigidité du rebondissement de la suspension arrière a un effet similaire sur la capacité de la suspension arrière à absorber les chocs et à revenir à sa position normale après une compression.",
                            "more details": "Les conséquences du réglage de la rigidité du rebondissement arrière sont les suivantes :<br>- Une rigidité plus élevée offre un meilleur contrôle sur les surfaces inégales, améliore la stabilité en virage, mais peut rendre la conduite plus dure et moins confortable."
                        }
                    ]
                },
                {
                    name: "bump_stiffness",
                    settings: [
                        {
                            name: "front",
                            explanations: "Le réglage de la rigidité de la suspension avant lors de l'absorption des chocs affecte la capacité de la suspension avant à réduire le roulis lors de la compression due à des bosses ou des irrégularités de la route.",
                            "more details": "Les conséquences du réglage de la rigidité de l'avant lors de l'absorption des chocs sont les suivantes :<br>- Des réglages plus rigides réduisent le roulis de la carrosserie de la voiture lors de la compression, ce qui peut améliorer la stabilité en virage, mais cela peut aussi rendre la conduite plus dure et affecter le confort."
                        },
                        {
                            name: "rear",
                            explanations: "Le réglage de la rigidité de la suspension arrière lors de l'absorption des chocs a un effet similaire sur la capacité de la suspension arrière à réduire le roulis lors de la compression due à des bosses ou des irrégularités de la route.",
                            "more details": "Les conséquences du réglage de la rigidité arrière lors de l'absorption des chocs sont les suivantes :<br>- Des réglages plus rigides réduisent le roulis de la carrosserie de la voiture lors de la compression, ce qui peut améliorer la stabilité en virage, mais cela peut aussi rendre la conduite plus dure et affecter le confort."
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
                            explanations: "Ajuste la force d'appui aérodynamique à l'avant.",
                            "more details": "Une plus grande force d'appui améliore la traction mais peut réduire la vitesse maximale."
                        },
                        {
                            name: "rear",
                            explanations: "Ajuste la force d'appui aérodynamique à l'arrière.",
                            "more details": "Une plus grande force d'appui améliore la traction mais peut réduire la vitesse maximale."
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
                            explanations: "Ajuste la répartition de la force de freinage entre l'avant et l'arrière.",
                            "more details": "Un équilibre orienté vers l'avant offre un meilleur contrôle, tandis qu'à l'arrière, il peut aider à tourner en freinant."
                        },
                        {
                            name: "pressure",
                            explanations: "Ajuste l'intensité globale de la force de freinage.",
                            "more details": "Une pression plus élevée augmente la réactivité des freins, mais peut entraîner un blocage plus facile des roues."
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
                            explanations: "Ajuste le degré de verrouillage du différentiel lors de l'accélération pour la partie avant.",
                            "more details": "Un niveau élevé augmente la traction mais peut rendre la voiture moins agile."
                        },
                        {
                            name: "deceleration",
                            explanations: "Ajuste le degré de verrouillage du différentiel lors de la décélération pour la partie avant.",
                            "more details": "Un niveau élevé améliore le contrôle lors du freinage mais peut causer un sous-virage."
                        }
                    ]
                },
                {
                    name: "rear",
                    settings: [
                        {
                            name: "acceleration",
                            explanations: "Ajuste le degré de verrouillage du différentiel lors de l'accélération pour la partie arrière.",
                            "more details": "Un niveau élevé augmente la traction mais peut rendre la voiture moins agile."
                        },
                        {
                            name: "deceleration",
                            explanations: "Ajuste le degré de verrouillage du différentiel lors de la décélération pour la partie arrière.",
                            "more details": "Un niveau élevé améliore le contrôle lors du freinage mais peut causer un sous-virage."
                        }
                    ]
                },
                {
                    name: "balance",
                    settings: [
                        {
                            name: "angle",
                            explanations: "Ajuste la répartition de la force entre les différentiels avant et arrière.",
                            "more details": "Un réglage favorisant l'avant peut améliorer la traction et la maniabilité dans les virages, tandis qu'un réglage favorisant l'arrière peut améliorer l'accélération en ligne droite."
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
                            explanations: "Modifie le rapport air/carburant dans le moteur.",
                            "more details": "Un mélange plus riche augmente la puissance mais peut réduire l'efficacité et augmenter les émissions."
                        }
                    ]
                },
                {
                    name: "ignition timing",
                    settings: [
                        {
                            name: "adjustment",
                            explanations: "Ajuste le moment de l'allumage de l'étincelle dans les cylindres.",
                            "more details": "Un avancement de l'allumage peut augmenter la puissance et l'efficacité, mais risque de causer de la détonation (cognement du moteur)."
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
                            explanations: "Contrôle la pression dans le système d'échappement.",
                            "more details": "Une pression plus faible peut augmenter la performance mais réduire le couple à bas régime."
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
                            explanations: "Gère le flux d'air entrant dans le moteur.",
                            "more details": "Un flux d'air accru améliore la réponse du moteur et la puissance, mais peut nécessiter des ajustements au niveau de la gestion du moteur."
                        }
                    ]
                }
            ]
        }
    }
];